<?php

namespace App\Controller;

use App\Entity\Cats;
use App\Enum\Gender;
use App\Repository\CaractereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CatsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Liste des chats de l'utilisateur connecté
     */
    #[Route('/cats', name: 'app_list_cats', methods: ['GET'])]
    public function listCats(UserInterface $user): Response
    {
        $cats = $this->entityManager
            ->getRepository(Cats::class)
            ->findBy(['user' => $user]);

        return $this->render('cats/list.html.twig', [
            'cats' => $cats,
        ]);
    }

    /**
     * Formulaire d'ajout de chat (GET)
     * On fournit la liste des traits de caractère pour cocher
     */
    #[Route('/cats/add/form', name: 'app_add_cat_form', methods: ['GET'])]
    public function addCatForm(CaractereRepository $caractereRepo): Response
    {
        $caracteres = $caractereRepo->findAll();

        return $this->render('cats/add_cat.html.twig', [
            'caracteres' => $caracteres,
        ]);
    }

    /**
     * Traitement de l'ajout de chat (POST)
     * On lit les caractères cochés et on les associe au chat
     */
    #[Route('/cats/add', name: 'app_add_cat', methods: ['POST'])]
    public function addCat(
        Request $request,
        UserInterface $user,
        CaractereRepository $caractereRepo
    ): Response {
        $name         = $request->request->get('name');
        $age          = $request->request->get('age');
        $breed        = $request->request->get('breed');
        $genderValue  = $request->request->get('gender');
        $description  = $request->request->get('description');
        $caractereIds = $request->request->all('caracteres', []);

        $gender = Gender::from($genderValue);

        if (!$user) {
            return $this->json([
                'message' => 'Vous devez être connecté pour ajouter un chat.'
            ], 403);
        }

        // Empêcher de réutiliser une même image
        $usedImageIds = $this->entityManager
            ->getRepository(Cats::class)
            ->createQueryBuilder('c')
            ->select('c.imageId')
            ->getQuery()
            ->getSingleColumnResult();

        $availableImageIds = array_diff(range(1, 10), $usedImageIds);
        if (empty($availableImageIds)) {
            return $this->render('cats/max_reached.html.twig', [
                'message' => 'Tous les chats ont une image attribuée. Vous ne pouvez plus en ajouter.'
            ]);
        }

        $imageId = $availableImageIds[array_rand($availableImageIds)];

        // Création de l'entité
        $cat = new Cats();
        $cat->setName($name)
            ->setAge((int)$age)
            ->setBreed($breed)
            ->setGender($gender)
            ->setDescription($description)
            ->setImageId($imageId)
            ->setUser($user);

        // Association des traits de caractère cochés
        foreach ($caractereIds as $id) {
            if ($car = $caractereRepo->find((int)$id)) {
                $cat->addCaractere($car);
            }
        }

        $this->entityManager->persist($cat);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_cat_success', [
            'id' => $cat->getId()
        ]);
    }

    /**
     * Page de succès après création
     */
    #[Route('/cats/success/{id}', name: 'app_cat_success', methods: ['GET'])]
    public function success(Cats $cat): Response
    {
        return $this->render('cats/success.html.twig', [
            'cat' => $cat
        ]);
    }

    /**
     * Mise à jour d'un chat (non modifié ici)
     */
    #[Route('/cats/update/{id}', name: 'app_update_cat', methods: ['POST'])]
    public function updateCat(
        Request $request,
        Cats $cat,
        UserInterface $user
    ): Response {
        if ($cat->getUser() !== $user) {
            return $this->json([
                'message' => 'Vous ne pouvez pas modifier ce chat.'
            ], 403);
        }

        $name        = $request->request->get('name');
        $age         = $request->request->get('age');
        $breed       = $request->request->get('breed');
        $genderValue = $request->request->get('gender');

        if (!empty($name)) {
            $cat->setName($name);
        }
        if (!empty($age)) {
            $cat->setAge((int)$age);
        }
        if (!empty($breed)) {
            $cat->setBreed($breed);
        }
        if (!empty($genderValue)) {
            $cat->setGender(Gender::from($genderValue));
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Chat mis à jour avec succès.'], 200);
    }
}
