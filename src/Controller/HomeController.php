<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    // Route pour la racine qui redirige vers /home
    #[Route('/', name: 'app_root')]
    public function rootRedirect(): RedirectResponse
    {
        return $this->redirectToRoute('app_home');
    }

    // Page d'accueil accessible à tous
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }
}

