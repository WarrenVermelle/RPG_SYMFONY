<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChampionController extends AbstractController
{
    #[Route('/champion', name: 'champion')]
    public function index(Request $request): Response
    {
        return $this->render('game/footer.html.twig', [
            'controller_name' => 'ChampionController',
            'champion' => $request->getSession()->get('championActif')
        ]);
    }
}
