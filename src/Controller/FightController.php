<?php

namespace App\Controller;


use App\Repository\ChampionRepository;
use App\Repository\ItemRepository;
use App\Service\FightService;
use Doctrine\ORM\Query\AST\BetweenExpression;
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
     * @Route("/combat/start", name="start")
     */
    public function start( ChampionRepository $champion, Request $request): Response
    {

        return $this->render('fight/fightStart.html.twig',[
            
            'monster' => $request->getSession()->get('monster'),
            'champion' => $champion->findOneBy([
                'player' => $this->getUser(),
                'actif' => true])
        ]);

    }

    /**
     * Undocumented function
     *
     * @Route("/combat/combat", name="combat")
     * 
     */
    public function combat(ChampionRepository $championRepository, FightService $fight,
                        UrlGeneratorInterface $generator, Request $request, ItemRepository $itemRepo): Response
    {   
        // prend le monstre stocké dans la session
        $session = $request->getSession();
        $monster = $session->get('monster');
        // prend le champion actif
        $champion = $championRepository->findOneBy([
            'player' => $this->getUser(),
            'actif' => true
        ]);

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
        ]);
    }


    /**
     * Undocumented function
     *
     * @Route("/combat/potioHeal", name="potioHeal")
     * 
     */
    public function potioHeal(ChampionRepository $championRepository,
                              FightService $fight,
                              UrlGeneratorInterface $generator, 
                              Request $request): Response
    {
        // prend le monstre stocké dans la session
        $monster = $request->getSession()->get('monster');
        // prend le champion actif
        $champion = $championRepository->findOneBy([
            'player' => $this->getUser(),
            'actif' => true]);

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
            'champion' => $championRepository->findOneBy([
                'player' => $this->getUser(),
                'actif' => true]),          
        ]);
    }


    /**
     * Undocumented function
     *
     * @Route("/combat/fuite", name="fuite")
     * 
     */
    public function fuite(ChampionRepository $championRepository, UrlGeneratorInterface $generator,
                        FightService $fight, Request $request)//: Response
    {
        
        $monster = $request->getSession()->get('monster');
        $champion = $championRepository->findOneBy([
            'player' => $this->getUser(),
            'actif' => true]);


        if($fight->escape($champion,$generator,$request))
        {
            return new JsonResponse($generator->generate('dynamic_map', ['id' => 4]));
        }else{
            return $this->potioHeal($championRepository,
             $fight,
             $generator, 
             $request);
        }
        
         ;

        
    }
}