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
        $manager = $this->getDoctrine()->getManager();

        // Si un champion est deja actif
        foreach ($this->getUser()->getChampions()->getValues() as $championFromDb) {
            if ($championFromDb->getActif())
            {
                // Désactiver l'ancien champion
                $championFromDb->setActif(false);
                $manager->persist($championFromDb);
            }

            // Activer le champion avec lequel joue
            $champion->setActif(true);
            $manager->persist($champion);
            $manager->flush();           
        }
        

        return $this->render('game/ville.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
