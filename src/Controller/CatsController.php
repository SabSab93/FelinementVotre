<?php


namespace App\Controller;

use App\Entity\Cats;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CatsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cats/add', name: 'app_add_cat', methods: ['POST'])]
    public function addCat(Request $request, AuthorizationCheckerInterface $authChecker): Response
    {

        $user = $this->getUser();
        
        if (!$user) {
            return $this->json(['message' => 'Vous devez être connecté pour ajouter un chat.'], 403);
        }


        if (!$authChecker->isGranted('ADD_CAT', $user)) {
            return $this->json(['message' => 'Vous n\'êtes pas autorisé à ajouter un chat.'], 403);
        }


        $data = json_decode($request->getContent(), true);


        if (!isset($data['name'], $data['age'], $data['breed'])) {
            return $this->json(['message' => 'Données invalides. Veuillez fournir le nom, l\'âge et la race du chat.'], 400);
        }

        // Création de l'entité Chat
        $cat = new Cats();
        $cat->setName($data['name']);
        $cat->setAge($data['age']);
        $cat->setBreed($data['breed']);
        $cat->setUser($user); // Lier l'utilisateur au chat

        // Enregistrement du chat dans la base de données
        $this->entityManager->persist($cat);
        $this->entityManager->flush();

        // Réponse de succès
        return $this->json(['message' => 'Chat ajouté avec succès.'], 200);
    }
}


