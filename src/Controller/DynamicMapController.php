<?php

namespace App\Controller;

use App\Repository\ChampionRepository;
use App\Repository\MapRepository;
use App\Repository\MonsterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game/voyage')]
class DynamicMapController extends AbstractController
{
    #[Route('/{id}', name: 'dynamic_map')]
    public function index($id, MapRepository $mapRepo, ChampionRepository $ChampionRepo, Request $request, MonsterRepository $monsterRepo): Response
    {
        $monsters = $monsterRepo->findAll();
        $request->getSession()->set('monster', $monsters[rand(0,count($monsters)-1)]);

        $mapSelect = $mapRepo->findOneBy(["id" => $id]);
        return $this->render('dynamic_map/index.html.twig', [
            'champion' => $ChampionRepo->findOneBy([
                "player" => $this->getUser(),
                "actif" => true
            ]),
            "name" => $mapSelect->getMapName(),
            "img" => $mapSelect->getImg(),
            "topfleche" => $mapSelect->getMapTop(),
            "rightfleche" => $mapSelect->getMapRight(),
            "bottomfleche" => $mapSelect->getMapBottom(),
            "leftfleche" => $mapSelect->getMapLeft(),
            "shop" => $mapSelect->getShop(),
            "fight" => $mapSelect->getFight(),
            "marchand" => $mapSelect->getMarchand(),
            'monster' => $request->getSession()->get('monster'),
        ]);
    }
}
