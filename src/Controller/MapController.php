<?php

namespace App\Controller;

use App\Repository\MonsterRepository;
use App\Repository\ChampionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/game/voyage')]
class MapController extends AbstractController
{
    #[Route('/map', name: 'map')]
    public function index(): Response
    {
        
        return $this->render('game/index.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }

    #[Route('/forest', name: 'forest')]
    public function forest(MonsterRepository $monster): Response
    {
        $idRandom = random_int(1, 3);

        return $this->render('game/foret.html.twig', [
            'monster' => $monster->find($idRandom),
            'controller_name' => 'MapController',
        ]);
    }

    #[Route('/ville', name: 'ville')]
    public function ville(): Response
    {
        

        return $this->render('game/ville.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }

    #[Route('/plaine', name: 'plaine')]
    public function plaine(): Response
    {
        return $this->render('game/plaine.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }

    #[Route('/boutique', name: 'boutique')]
    public function boutique(): Response
    {
        return $this->render('game/boutique.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }

    #[Route('/mob', name: 'mob')]
    public function apparitionMob(): Response
    {
        return $this->render('game/mob.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }
}
