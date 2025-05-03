<?php
namespace App\Controller;

use App\Entity\Cats;
use App\Repository\CatsRepository;
use App\Repository\ConqueteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConqueteController extends AbstractController
{
    #[Route('/conquete/match/{catId}', name: 'app_conquete_match', methods: ['GET'])]
    public function match(
        int $catId,
        CatsRepository $catRepo,
        ConqueteRepository $conqRepo
    ): Response {
        $cat = $catRepo->find($catId);
        if (!$cat || $cat->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        // Récupère toutes les conquêtes
        $conquetes = $conqRepo->findAll();
        $matches = [];

        foreach ($conquetes as $conq) {
            // *** ICI *** Calcule ton score de compatibilité
            // Pour l'instant, on fait un score aléatoire entre 50 et 95
            $score = random_int(50, 95);

            $matches[] = [
                'conquete' => $conq,
                'score'    => $score,
            ];
        }

        return $this->render('conquete/match.html.twig', [
            'cat'     => $cat,
            'matches' => $matches,
        ]);
    }
}
