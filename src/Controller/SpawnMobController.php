<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpawnMobController extends AbstractController
{
    #[Route('/spawn/mob', name: 'spawn_mob')]
    public function index(): Response
    {
        return $this->render('spawn_mob/index.html.twig', [
            'controller_name' => 'SpawnMobController',
        ]);
    }
}
