<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        // Vérifie les données reçues du formulaire
        $data = json_decode($request->getContent(), true);

        // Log des données pour voir ce qui est reçu
        dump($data); // Affiche les données reçues, elles doivent être un tableau avec 'name', 'email' et 'password'

        // Vérifie si $data est valide
        if (!is_array($data) || !isset($data['name'], $data['email'], $data['password'])) {
            // Si les données ne sont pas valides, renvoie une réponse d'erreur
            return new Response('Données invalides', Response::HTTP_BAD_REQUEST);
        }

        // Création de l'utilisateur
        $user = new Users();
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        // Log avant de hacher le mot de passe
        dump('Avant le hachage du mot de passe'); 

        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Log du mot de passe haché
        dump('Mot de passe haché : ', $hashedPassword);

        $user->setCreatedAt(new \DateTimeImmutable());

        // Persiste l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès', 'redirect' => $this->generateUrl('app_list_cats')], Response::HTTP_CREATED);

    }


    #[Route('/register', name: 'app_register_form', methods: ['GET'])]
public function registerForm(): Response
{
    return $this->render('security/register.html.twig');
}



}
