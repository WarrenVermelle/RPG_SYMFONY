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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
    public function combat(Monster $monster, ChampionRepository $championRepository, FightService $fight, UrlGeneratorInterface $generator): Response
    {
       
        
        
        //mise a jour des hp du monstre
        $updateHpMonster = $fight->atkChamp($championRepository->findAll()[0], $monster);
        //mise a jour des hp du champion
        $updateHpChamp = $fight->atkMonster($championRepository->findAll()[0], $monster);
        //Si les hp du monstre tombe a 0
        if ( $monster->getHp() <= 0) {
            
            //alors le champion obtient son xp
            $fight->xpWin($championRepository->findAll()[0],$monster);
            //et son or
            $fight->goldWin($championRepository->findAll()[0],$monster);

            $levelUp = $championRepository->findAll()[0]->getLevel() * 100;
            //si l'xp total du champion est égale au level du champion fois 100
            $monsterReset = $monster->getHpMax();
            $monster->setHp($monsterReset);
            
            if ($championRepository->findAll()[0]->getXp() >= $levelUp) {
                //alors on execute la fonction levelUp
                $fight->levelUp($championRepository->findAll()[0]);
                //et on remet à 0 l'xp du champion
                // ----> $fight->xpReset($championRepository->findAll()[0]);
            }
            

        return new JsonResponse($generator->generate('forest'));
            
            
        }

        
        
    
        
        return $this->render('fight/fightStart.html.twig',[
            'monster' => $monster,
            'champion' => $championRepository->findAll()[0],          
        ]);
    }

}