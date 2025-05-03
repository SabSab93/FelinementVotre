<?php

namespace App\Controller;

use App\Entity\Cats;
use App\Entity\Conquete;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/cats/{cat}/match/{conquete}', name: 'app_cat_match', methods: ['POST'])]
    public function match(
        Cats $cat,
        Conquete $conquete,
        EntityManagerInterface $em
    ): Response {
        $cat->addConquete($conquete);
        $em->flush();


        return $this->json(['success' => true]);
    }
}
