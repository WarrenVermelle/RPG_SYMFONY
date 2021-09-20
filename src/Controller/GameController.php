<?php

namespace App\Controller;

use App\Entity\Champion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game')]
class GameController extends AbstractController
{
    #[Route('/{id}', name: 'game')]
    public function index(Champion $champion): Response
    {

        return $this->render('game/ville.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
