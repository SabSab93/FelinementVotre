<?php

namespace App\Controller;

use App\Entity\Cats;
use App\Enum\Gender;
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

    // Affiche la liste des chats de l'utilisateur
    #[Route('/cats', name: 'app_list_cats', methods: ['GET'])]
    public function listCats(UserInterface $user): Response
    {
        // Récupère les chats associés à l'utilisateur
        $cats = $this->entityManager->getRepository(Cats::class)->findBy(['user' => $user]);

        return $this->render('cats/list.html.twig', [
            'cats' => $cats,
        ]);
    }

    // Afficher le formulaire pour ajouter un chat
    #[Route('/cats/add/form', name: 'app_add_cat_form', methods: ['GET'])]
    public function addCatForm(): Response
    {
        return $this->render('cats/add_cat.html.twig');
    }

    // Ajouter un chat
    #[Route('/cats/add', name: 'app_add_cat', methods: ['POST'])]
    public function addCat(Request $request, UserInterface $user): Response
    {
        $name = $request->request->get('name');
        $age = $request->request->get('age');
        $breed = $request->request->get('breed');
        $genderValue = $request->request->get('gender');
        $gender = Gender::from($genderValue);  // Utilisation de l'enum Gender

        if (!$user) {
            return $this->json(['message' => 'Vous devez être connecté pour ajouter un chat.'], 403);
        }

        // Création du chat et association avec l'utilisateur
        $cat = new Cats();
        $cat->setName($name);
        $cat->setAge($age);
        $cat->setBreed($breed);
        $cat->setGender($gender);  // Utilisation de l'enum Gender
        $cat->setUser($user);

        // Persister le chat dans la base de données
        $this->entityManager->persist($cat);
        $this->entityManager->flush();

        // Réponse de succès
        return $this->json(['message' => 'Chat ajouté avec succès.'], 200);
    }

    // Mise à jour du chat (formulaire et traitement)
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
        $gender = Gender::from($genderValue);  // Utilisation de l'enum Gender

        // Mise à jour des informations du chat
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
            $cat->setGender($gender);  // Utilisation de l'enum Gender
        }

        // Sauvegarde des changements
        $this->entityManager->flush();

        return $this->json(['message' => 'Chat mis à jour avec succès.'], 200);
    }
}