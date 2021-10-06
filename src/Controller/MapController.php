<?php

namespace App\Controller;

use App\Repository\MonsterRepository;
use App\Repository\ChampionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/game/voyage')]
class MapController extends AbstractController
{
    #[Route('/map', name: 'map')]
    public function index(): Response
    {
        return $this->render('game/index.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }

    #[Route('/forest', name: 'forest')]
    public function forest(MonsterRepository $monsterRepo, ChampionRepository $ChampionRepo, Request $request): Response
    {
        $monsters = $monsterRepo->findAll();
        $request->getSession()->set('monster', $monsters[rand(0,count($monsters)-1)]);

        return $this->render('game/foret.html.twig', [
            'monster' => $request->getSession()->get('monster'),
            'controller_name' => 'MapController',
            'champion' => $ChampionRepo->findOneBy(["player" => $this -> getUser(), 'actif' =>true])
        ]);
    }

    #[Route('/ville', name: 'ville')]
    public function ville(ChampionRepository $ChampionRepo): Response
    {
        return $this->render('game/ville.html.twig', [
            'champion' => $ChampionRepo->findOneBy([
                "player" => $this->getUser(),
                "actif" => true
            ]),
            'controller_name' => 'MapController',
            'champion' => $ChampionRepo->findOneBy(["player" => $this -> getUser(), 'actif' =>true])
        ]);
    }

    #[Route('/plaine', name: 'plaine')]
    public function plaine(ChampionRepository $ChampionRepo, Request $request): Response
    {
        dump($request->getSession()->get('championActif'));
        return $this->render('game/plaine.html.twig', [
            'controller_name' => 'MapController',
            'champion' => $ChampionRepo->findOneBy(["player" => $this -> getUser(), 'actif' =>true])
        ]);
    }

    #[Route('/boutique', name: 'boutique')]
    public function boutique(ChampionRepository $ChampionRepo): Response
    {
        return $this->render('game/boutique.html.twig', [
            'champion' => $ChampionRepo->findOneBy(["player" => $this -> getUser(), 'actif' =>true]),
        ]);
    }

    #[Route('/mob', name: 'mob')]
    public function apparitionMob(): Response
    {
        return $this->render('game/mob.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }
}
