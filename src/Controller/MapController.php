<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function forest(): Response
    {
        return $this->render('game/foret.html.twig', [
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
}
