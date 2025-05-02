<?php

namespace App\Controller;

use App\Entity\Cats;
use App\Entity\Caractere;
use App\Enum\Gender;
use App\Repository\CaractereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

class CatsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cats', name: 'app_list_cats', methods: ['GET'])]
    public function listCats(UserInterface $user): Response
    {
        $cats = $this->entityManager->getRepository(Cats::class)->findBy(['user' => $user]);

        return $this->render('cats/list.html.twig', [
            'cats' => $cats,
        ]);
    }

    #[Route('/cats/add/form', name: 'app_add_cat_form', methods: ['GET'])]
    public function addCatForm(CaractereRepository $caractereRepo): Response
    {
        $caracteres = $caractereRepo->findAll();
        return $this->render('cats/add_cat.html.twig', [
            'caracteres' => $caracteres
        ]);
    }

    #[Route('/cats/add', name: 'app_add_cat', methods: ['POST'])]
    public function addCat(Request $request, UserInterface $user, CaractereRepository $caractereRepo): Response
    {
        $name = $request->request->get('name');
        $age = $request->request->get('age');
        $breed = $request->request->get('breed');
        $genderValue = $request->request->get('gender');
        $description = $request->request->get('description');
        $caractereIds = $request->request->all('caracteres');

        $gender = Gender::from($genderValue);

        if (!$user) {
            return $this->json(['message' => 'Vous devez être connecté pour ajouter un chat.'], 403);
        }

        $cat = new Cats();
        $cat->setName($name);
        $cat->setAge($age);
        $cat->setBreed($breed);
        $cat->setGender($gender);
        $cat->setDescription($description);
        $cat->setImageId(random_int(1, 10));
        $cat->setUser($user);

        foreach ($caractereIds as $id) {
            $caractere = $caractereRepo->find($id);
            if ($caractere) {
                $cat->addCaractere($caractere);
            }
        }

        $this->entityManager->persist($cat);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_cat_success', ['id' => $cat->getId()]);
    }

    #[Route('/cats/success/{id}', name: 'app_cat_success', methods: ['GET'])]
    public function success(Cats $cat): Response
    {
        return $this->render('cats/success.html.twig', [
            'cat' => $cat
        ]);
    }

    #[Route('/cats/update/{id}', name: 'app_update_cat', methods: ['POST'])]
    public function updateCat(Request $request, Cats $cat, UserInterface $user): Response
    {
        if ($cat->getUser() !== $user) {
            return $this->json(['message' => 'Vous ne pouvez pas modifier ce chat.'], 403);
        }

        $name = $request->request->get('name');
        $age = $request->request->get('age');
        $breed = $request->request->get('breed');
        $genderValue = $request->request->get('gender');
        $gender = Gender::from($genderValue);

        if (!empty($name)) {
            $cat->setName($name);
        }
        if (!empty($age)) {
            $cat->setAge($age);
        }
        if (!empty($breed)) {
            $cat->setBreed($breed);
        }
        if (!empty($gender)) {
            $cat->setGender($gender);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Chat mis à jour avec succès.'], 200);
    }
}
