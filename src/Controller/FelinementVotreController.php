<?php

// src/Controller/FelinementVotreController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FelinementVotreController extends AbstractController
{
    // Page principale de felinementvotre
    #[Route('/felinementvotre', name: 'app_felinementvotre')]
    public function index(): Response
    {
        // Vérification si l'utilisateur est connecté
        if (!$this->getUser()) {
            // Redirige l'utilisateur vers la page de connexion si non authentifié
            return $this->redirectToRoute('app_login');
        }

        // Si connecté, afficher la page de felinementvotre
        return $this->render('home/felinementvotre.html.twig');
    }
}
