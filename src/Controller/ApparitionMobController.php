<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApparitionMobController extends AbstractController
{
    #[Route('/apparition/mob', name: 'apparition_mob')]
    public function apparitionMob(): Response
    {   
        return $this->render('apparition_mob/index.html.twig', [
            'controller_name' => 'ApparitionMobController',
        ]);
    }

    #[Route('/games/mob', name: 'game_mob')]
    public function leaveFight(): Response
    {   
        return $this->render('game/mob.html.twig', [
            'controller_name' => 'ApparitionMobController',
        ]);
    }
}
