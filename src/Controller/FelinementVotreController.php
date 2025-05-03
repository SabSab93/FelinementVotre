<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FelinementVotreController extends AbstractController
{

    #[Route('/felinementvotre', name: 'app_felinementvotre')]
    public function index(): Response
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home/felinementvotre.html.twig');
    }
}
