<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Entity\Monster;
use App\Repository\ChampionRepository;
use App\Repository\MonsterRepository;
use App\Service\FightService;
use Doctrine\ORM\Mapping\Id;
use phpDocumentor\Reflection\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FightController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @Route("/start/{id}", name="start")
     */
    public function start(Monster $monster, ChampionRepository $champion): Response
    {
        return $this->render('fight/fightStart.html.twig',[
            
            'monster' => $monster,
            'champion' => $champion->findAll()[0]
        ]);
        
    }

    /**
     * Undocumented function
     *
     * @Route("/combat/{id}", name="combat")
     * 
     */
    public function combat(Monster $monster, ChampionRepository $championRepository, FightService $fight): Response
    {
       


        //mise a jour des hp du monstre
        $updateHpMonster = $fight->atkChamp($championRepository->findAll()[0], $monster);
        //mise a jour des hp du champion
        $updateHpChamp = $fight->atkMonster($championRepository->findAll()[0], $monster);
        //Si les hp du monstre tombe a 0
        if ( $monster->getHp() === 0) {
            //alors le champion obtient son xp
            $fight->xpWin($championRepository->findAll()[0],$monster);
            //et son or
            $fight->goldWin($championRepository->findAll()[0],$monster);
            return $this->redirectToRoute('start', [
                'id' => $monster->getId()
            ]);
        }
        
        
        return $this->render('fight/fightStart.html.twig',[
            'monster' => $monster,
            'champion' => $championRepository->findAll()[0],          
        ]);
    }

}