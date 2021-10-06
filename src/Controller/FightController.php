<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Gender;
use App\Entity\Race;
use App\Entity\Faction;
use App\Entity\Champion;
use App\Service\FightService;
use App\Repository\ImgPersoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/combat')]
class FightController extends AbstractController
{
    #[Route('/start', name:'start')]
    public function start(Request $request,ImgPersoRepository $imgPersoRepo): Response
    {
        $session = $request->getSession();

        $champion = $session->get('championActif');
        $manager = $this->getDoctrine()->getManager();
        $champion = $manager->find(Champion::class, $champion->getId());

        return $this->render('fight/fightStart.html.twig',[
            
            'monster' => $session->get('monster'),
            'champion' => $champion,
            'img' => $imgPersoRepo->findOneBy([
                'gender' => $champion->getGender(),
                'race' => $champion->getRace(),
                'faction' => $champion->getFaction(),
            ])
        ]);
    }

    #[Route('/combat', name:'combat')]
    public function combat(FightService $fight,
                           UrlGeneratorInterface $generator, 
                           Request $request,ImgPersoRepository $imgPersoRepo): Response
    {   
        $session = $request->getSession();
        $monster = $session->get('monster');
        $champion = $session->get('championActif');

        // base de la prise de niveau
        $levelUp = $champion->getLevel() * 100;
        // récup img champion
        $manager = $this->getDoctrine()->getManager();
        $champion = $manager->find(Champion::class, $champion->getId());
        
        $vieavant = $champion->getHp();
        $viemstavant = $monster->getHp();
        // met a jour les pv du monstre après l'attaque du champion (session)
        $session->set('monster', $fight->atkChamp($champion, $monster));

        // si les pv du monstre tombent à 0
        if ($monster->getHp() <= 0) {
            // le champion obtient son xp
            $fight->xpWin($champion,$monster);
            $xpFight = $monster->getXp();
            // le champion obtient son or
            $fight->goldWin($champion,$monster);
            $goldFight = $monster->getGold();
            
            // 1 chance sur 3 d'obtenir un loot
            if(rand(0,2) === 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $loots = $monster->getLoots()->getValues();
                $loot = $loots[rand(0,count($loots)-1)];

                $champion->addLootToInventory($manager->find(Item::class, $loot->getItem()->getId()));
                $session->set('loot', $loot);
                $manager->persist($champion);
                $manager->flush();
            }

            $session->set('xpFight', $xpFight);
            $session->set('goldFight', $goldFight);
            

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
            return new JsonResponse($generator->generate('win'));
        }

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
            return new JsonResponse($generator->generate('lose'));
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
            'attacMonster' => $vieavant - $champion->getHp(),
            'img' => $imgPersoRepo->findOneBy([
                'gender' => $champion->getGender(),
                'race' => $champion->getRace(),
                'faction' => $champion->getFaction(),
            ])
        ]);
    }

    #[Route('/potioHeal', name:'potioHeal')]
    public function potioHeal(FightService $fight,
                              UrlGeneratorInterface $generator, 
                              Request $request, ImgPersoRepository $imgPersoRepo): Response
    {
        $session = $request->getSession();
        $monster = $session->get('monster');
        $champion = $session->get('championActif');

        $manager = $this->getDoctrine()->getManager();
        $champion = $manager->find(Champion::class, $champion->getId());
        $vieavant = $champion->getHp();
        $fight->atkMonster($champion, $monster);
        // si les pv du champion tombent à 0 ou moins
        if ($champion->getHp() <= 0 ) {
            $manager = $this->getDoctrine()->getManager();
            // remet les pv à 1
            $champion->setHp(1);
            $manager->persist($champion);
            $manager->flush();
            // renvoi à la ville
            return new JsonResponse($generator->generate('lose'));
        }
        
        return $this->render('fight/fightStart.html.twig',[
            'monster' => $monster,
            'champion' => $champion,          
            'attacMonster' => $vieavant - $champion->getHp(),
            'img' => $imgPersoRepo->findOneBy([
                'gender' => $champion->getGender(),
                'race' => $champion->getRace(),
                'faction' => $champion->getFaction(),
            ])     
        ]);
    }

    #[Route('/fuite', name:'fuite')]
    public function fuite(UrlGeneratorInterface $generator,
                          FightService $fight, 
                          Request $request,ImgPersoRepository $imgPersoRepo)//: Response
    {
        $monster = $request->getSession()->get('monster');
        $champion = $request->getSession()->get('championActif');


        if($fight->escape($champion,$generator,$request,$imgPersoRepo))
        {
            return new JsonResponse($generator->generate('dynamic_map', ['id' => 4]));
        }
        else
        {
            return $this->potioHeal($fight, $generator, $request,$imgPersoRepo);
        }        
    }
}