<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Entity\Monster;
use App\Repository\ChampionRepository;
use App\Repository\MonsterRepository;
use App\Service\FightService;
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
        return $this->render('default/fightStart.html.twig',[
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
        //mise a jour des hp du monstre
        $updateHpMonster = $fight->atkChamp($championRepository->findAll()[0], $monsterRepository->findAll()[0]);
        //mise a jour des hp du champion
        $updateHpChamp = $fight->atkMonster($championRepository->findAll()[0], $monsterRepository->findAll()[0]);

        return $this->render('default/fightAtk.html.twig',[
            'monster' => $monsterRepository->findAll()[0],
            'champion' => $championRepository->findAll()[0],          
        ]);
    }

}