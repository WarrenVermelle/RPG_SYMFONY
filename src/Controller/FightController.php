<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ChampionRepository;
use App\Service\FightService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/combat')]
class FightController extends AbstractController
{
    #[Route('/start', name:'start')]
    public function start(Request $request): Response
    {
        $session = $request->getSession();

        return $this->render('fight/fightStart.html.twig',[
            
            'monster' => $session->get('monster'),
            'champion' => $session->get('championActif')
        ]);
    }

    #[Route('/combat', name:'combat')]
    public function combat(FightService $fight,
                           UrlGeneratorInterface $generator, 
                           Request $request): Response
    {   
        $session = $request->getSession();
        $monster = $session->get('monster');
        $champion = $session->get('championActif');

        $vieavant = $champion->getHp();
        $viemstavant = $monster->getHp();
        // met a jour les pv du monstre après l'attaque du champion (session)
        $session->set('monster', $fight->atkChamp($champion, $monster));
        // met à jour les pv du champion après l'attaque du monstre (bdd)
        $fight->atkMonster($champion, $monster);

        // si les pv du champion tombent à 0 ou moins
        if($champion->getHp() <= 0)
        {
            $manager = $this->getDoctrine()->getManager();
            // remet les pv à 1
            $champion->setHp(1);
            $manager->persist($champion);
            $manager->flush();
            // renvoi à la ville
            return new JsonResponse($generator->generate('dynamic_map', ['id' => 1]));
        }

        // base de la prise de niveau
        $levelUp = $champion->getLevel() * 100;

        // si les pv du monstre tombent à 0
        if ($monster->getHp() <= 0) {
            // le champion obtient son xp
            $fight->xpWin($champion,$monster);
            // le champion obtient son or
            $fight->goldWin($champion,$monster);

            // 1 chance sur 3 d'obtenir un loot
            if(rand(0,2) === 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $loots = $monster->getLoots()->getValues();
                $loot = $loots[rand(0,count($loots)-1)];
    
                $champion->addLootToInventory($manager->find(Item::class, $loot->getItem()->getId()));
                
                $manager->persist($champion);
                $manager->flush();
            }

            // si l'xp total du champion est supérieure ou égale à la base de prise de niveau
            if ($champion->getXp() >= $levelUp) {
                // alors on execute la fonction levelUp
                $fight->levelUp($champion);
                // remet les pv et pm au max
                $champion->setHp($champion->getMaxHp());
                $champion->setMp($champion->getMaxMp());
                // remet à 0 l'xp du champion
                $fight->xpReset($champion);
            }
            // renvoi à la forêt après le combat
            return new JsonResponse($generator->generate('dynamic_map', ['id' => 4]));
        }

        // si l'xp totale du champion est égale à la base de prise de niveau
        if ($champion->getXp() >= $levelUp) {
            // alors on execute la fonction levelUp
            
            $fight->levelUp($champion);
            // remet les pv et pm au max
            $champion->setHp($champion->getMaxHp());
            $champion->setMp($champion->getMaxMp());
            // remet à 0 l'xp du champion
            $fight->xpReset($champion);
        }
        
        return $this->render('fight/fightStart.html.twig',[
            'monster' => $monster,
            'champion' => $champion,
            'attacPerso' => $viemstavant - $monster->getHp(),
            'attacMonster' => $vieavant - $champion->getHp()
        ]);
    }

    #[Route('/potioHeal', name:'potioHeal')]
    public function potioHeal(FightService $fight,
                              UrlGeneratorInterface $generator, 
                              Request $request): Response
    {
        $session = $request->getSession();
        $monster = $session->get('monster');
        $champion = $session->get('championActif');

        $fight->atkMonster($champion, $monster);
        // si les pv du champion tombent à 0 ou moins
        if ($champion->getHp() <= 0 ) {
            $manager = $this->getDoctrine()->getManager();
            // remet les pv à 1
            $champion->setHp(1);
            $manager->persist($champion);
            $manager->flush();
            // renvoi à la ville
            return new JsonResponse($generator->generate('dynamic_map', ['id' => 4]));
        }
        
        return $this->render('fight/fightStart.html.twig',[
            'monster' => $monster,
            'champion' => $champion,          
        ]);
    }

    #[Route('/fuite', name:'fuite')]
    public function fuite(UrlGeneratorInterface $generator,
                          FightService $fight, 
                          Request $request)//: Response
    {
        $monster = $request->getSession()->get('monster');
        $champion = $request->getSession()->get('championActif');


        if($fight->escape($champion,$generator,$request))
        {
            return new JsonResponse($generator->generate('dynamic_map', ['id' => 4]));
        }
        else
        {
            return $this->potioHeal($fight, $generator, $request);
        }        
    }
}