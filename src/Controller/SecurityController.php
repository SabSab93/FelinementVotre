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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $entityManager;

    // Injection de l'EntityManagerInterface via le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/felinementvotre', name: 'app_felinementvotre')]
    public function felinementVoter(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('home/felinementvotre.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data) || !isset($data['name'], $data['email'], $data['password'])) {
            return new Response('Données invalides', Response::HTTP_BAD_REQUEST);
        }

        $user = new Users();
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Utilisateur créé avec succès', 
            'redirect' => $this->generateUrl('app_felinementvotre')
        ], Response::HTTP_CREATED);
    }

    #[Route('/register', name: 'app_register_form', methods: ['GET'])]
    public function registerForm(): Response
    {
        return $this->render('security/register.html.twig');
    }

    #[Route('/login', name: 'app_login', methods: ['GET','POST'])]
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()) {
            // Redirect if the user is already logged in
            return $this->redirectToRoute('app_felinementvotre');
        }

        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

}



