<?php


namespace App\Controller;

use App\Repository\CatsRepository;
use App\Repository\ConqueteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConqueteController extends AbstractController
{
    #[Route('/conquete/match/{catId}', name: 'app_conquete_match', methods:['GET'])]
    public function match(
        int $catId,
        CatsRepository $cats,
        ConqueteRepository $conqRepo
    ): Response {
        $cat = $cats->find($catId);
        if (!$cat || $cat->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $matches = [];
        foreach ($conqRepo->findAll() as $conq) {
            $score = random_int(50,95);
            $matches[] = ['conquete'=> $conq, 'score'=> $score];
        }

        return $this->render('conquete/match.html.twig', [
            'cat'     => $cat,
            'matches' => $matches,
        ]);
    }
}
