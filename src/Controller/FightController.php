<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Entity\Monster;
use App\Repository\ChampionRepository;
use App\Repository\MonsterRepository;
use App\Service\FightService;
use phpDocumentor\Reflection\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FightController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @Route("/start", name="start")
     */
    public function start(MonsterRepository $monster, ChampionRepository $champion): Response
    {
        return $this->render('fight/fightStart.html.twig',[
            'monster' => $monster->findAll()[0],
            'champion' => $champion->findAll()[0]
        ]);
    }

    /**
     * Undocumented function
     *
     * @Route("/combat", name="combat")
     * 
     */
    public function combat(MonsterRepository $monsterRepository, ChampionRepository $championRepository, FightService $fight): Response
    {
        $monsters = $monsterRepository->findAll()[0];


        //mise a jour des hp du monstre
        $updateHpMonster = $fight->atkChamp($championRepository->findAll()[0], $monsterRepository->findAll()[0]);
        //mise a jour des hp du champion
        $updateHpChamp = $fight->atkMonster($championRepository->findAll()[0], $monsterRepository->findAll()[0]);
        //Si les hp du monstre tombe a 0
        if ( $monsters->getHp() === 0) {
            //alors le champion obtient son xp
            $fight->xpWin($championRepository->findAll()[0],$monsterRepository->findAll()[0]);
            //et son or
            $fight->goldWin($championRepository->findAll()[0],$monsterRepository->findAll()[0]);
            return $this->redirectToRoute('start');
        }
        
        
        return $this->render('fight/fightAtk.html.twig',[
            'monster' => $monsterRepository->findAll()[0],
            'champion' => $championRepository->findAll()[0],          
        ]);
    }

}