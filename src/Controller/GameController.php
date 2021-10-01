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

            // Activer le champion avec lequel on joue
            $champion->setActif(true);
            $manager->persist($champion);
            $manager->flush();           
        }        

        return $this->redirectToRoute('dynamic_map',['id' => $champion->getPosition()->getId()]);
    }

    #[Route('/sleep/{id}', name: 'sleep')]
    public function sleep(Champion $champion)
    {
        # Si les Pv du champion sont inférieur aux pv max
        if ($champion->getActif() && ($champion->getHp() < $champion->getMaxHp() || $champion->getMp() < $champion->getMaxMp()))
        {
            // Pv champion = pv max
            $champion->setHp($champion->getMaxHp());
            $champion->setMp($champion->getMaxMp());
            $champion->setGold($champion->getGold() - 200);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($champion);
            $manager->flush();
            $this->addFlash("notice", "Vous êtes reposé");
        }    
        else
        {
            // Envoyer message "Vous déjà êtes reposé"
            $this->addFlash("notice", "Vous êtes déjà reposé");
        }
        
        return $this->redirectToRoute('ville');
    }
}
