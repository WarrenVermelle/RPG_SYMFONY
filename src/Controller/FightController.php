<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Entity\Monster;
use App\Repository\ChampionRepository;
use App\Repository\InventoryRepository;
use App\Repository\ItemRepository;
use App\Repository\TypeRepository;
use App\Service\FightService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
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
            'champion' => $champion->findOneBy([
                'player' => $this->getUser(),
                'actif' => true])
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
        // $test2 = $test->findOneBy(['actif' => 1]);
        $champion = $championRepository->findOneBy([
            'player' => $this->getUser(),
            'actif' => true]);
        //mise a jour des hp du monstre
        $updateHpMonster = $fight->atkChamp($champion, $monster);
        //mise a jour des hp du champion
        $updateHpChamp = $fight->atkMonster($champion, $monster);

        if ($champion->getHp() <= 0 ) {
            $monsterReset = $monster->getHpMax();
            $monster->setHp($monsterReset);
            $manager = $this->getDoctrine()->getManager();
            
            
            $monsterReset = $monster->getHpMax();
            $monster->setHp($monsterReset);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($monster);
            $manager->flush();

            return new JsonResponse($generator->generate('ville'));
        }

        //Si les hp du monstre tombe a 0
        if ( $monster->getHp() <= 0) {
            
            //alors le champion obtient son xp
            $fight->xpWin($champion,$monster);
            //et son or
            $fight->goldWin($champion,$monster);

            $levelUp = $champion->getLevel() * 100;
            //si l'xp total du champion est égale au level du champion fois 100
            $monsterReset = $monster->getHpMax();
            $monster->setHp($monsterReset);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($monster);
            $manager->flush();

            if ($champion->getXp() >= $levelUp) {
                //alors on execute la fonction levelUp
                $fight->levelUp($champion);
                //et on remet à 0 l'xp du champion
                $fight->xpReset($champion);
            }
            

        return new JsonResponse($generator->generate('forest'));
        }
        //je récupère le calcul d'xp max avec le level du champion
        $levelUp = $champion->getLevel() * 100;
        //si l'xp total du champion est égale au level du champion fois 100
        if ($champion->getXp() === $levelUp) {
            //alors on execute la fonction levelUp
            $fight->levelUp($champion);
            //et on remet à 0 l'xp du champion
            $fight->xpReset($champion);
        }
        
        return $this->render('fight/fightStart.html.twig',[
            'monster' => $monster,
            'champion' => $champion,          
        ]);
    }


    /**
     * Undocumented function
     *
     * @Route("game/potioHeal/{id}", name="potioHeal")
     * 
     */
    public function potioHeal(
        ChampionRepository $championRepository,
        FightService $fight, UrlGeneratorInterface $generator, Request $request): Response
    {

        $manager = $this->getDoctrine()->getManager();
        $monster = $request->getSession()->get('monster');
        $inventory = $request->getSession()->get('inventory');
        //dump($inventory);

        $item = $request->getSession()->get('Item');

        $champion = $championRepository->findOneBy([
            'player' => $this->getUser(),
            'actif' => true]);
        
        //$champion->removeInventory($item, $manager);
        
        $champion->setHp($champion->getHp() + $item->getHp());


        // //mise a jour des hp du champion
         $updateHpChamp = $fight->atkMonster($champion, $monster);

        //mise a jour des hp du monstre
        //$updateHpMonster = $fight->atkChamp($champion, $monster);
        

        if ($champion->getHp() <= 0 ) {
            $monsterReset = $monster->getHpMax();
            $monster->setHp($monsterReset);
            
           

            $monsterReset = $monster->getHpMax();
            $monster->setHp($monsterReset);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($monster);
            $manager->flush();

            return new JsonResponse($generator->generate('ville'));
        }

        //Si les hp du monstre tombe a 0
        if ( $monster->getHp() <= 0) {
            
            //alors le champion obtient son xp
            $fight->xpWin($champion,$monster);
            //et son or
            $fight->goldWin($champion,$monster);

            $levelUp = $champion->getLevel() * 100;
            //si l'xp total du champion est égale au level du champion fois 100
            $monsterReset = $monster->getHpMax();
            $monster->setHp($monsterReset);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($monster);
            $manager->flush();
    
            if ($champion->getXp() >= $levelUp) {
                //alors on execute la fonction levelUp
                $fight->levelUp($champion);
                //et on remet à 0 l'xp du champion
                $fight->xpReset($champion);
            }
            

        return new JsonResponse($generator->generate('forest'));
            
            
        }

        
        
    
        
        return $this->render('fight/fightStart.html.twig',[
            'monster' => $monster,
            'champion' => $championRepository->findOneBy([
                'player' => $this->getUser(),
                'actif' => true]),          
        ]);
    }
}