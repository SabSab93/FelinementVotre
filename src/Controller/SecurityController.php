<?php

// src/Controller/SecurityController.php

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
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!is_array($data) || !isset($data['name'], $data['email'], $data['password'])) {
                return new JsonResponse(['message' => 'Données invalides'], Response::HTTP_BAD_REQUEST);
            }

            $existingUser = $this->entityManager->getRepository(Users::class)->findOneBy(['email' => $data['email']]);

            if ($existingUser) {
                return new JsonResponse(['message' => 'Cet email est deja utilise.'], Response::HTTP_CONFLICT);
            }

            $user = new Users();
            $user->setName($data['name']);
            $user->setEmail($data['email']);
            $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
            $user->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse([
                'message' => 'Utilisateur créé avec succès',
                'redirect' => $this->generateUrl('app_login')
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return new JsonResponse(['message' => 'Erreur serveur : ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/register', name: 'app_register_form', methods: ['GET'])]
    public function registerForm(): Response
    {
        return $this->render('security/register.html.twig');
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_felinementvotre');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
