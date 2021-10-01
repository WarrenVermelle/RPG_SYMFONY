<?php

namespace App\Controller;

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
    public function index($id, 
                          MapRepository $mapRepo, 
                          Request $request, 
                          MonsterRepository $monsterRepo): Response
    {
        // passe le monstre dans la session
        $monsters = $monsterRepo->findAll();
        $request->getSession()->set('monster', $monsters[rand(0,count($monsters)-1)]);
        // champion connecté
        $champion = $request->getSession()->get('championActif');
        // map actuelle
        $mapSelect = $mapRepo->findOneBy(["id" => $id]);
        // stocke la position dans le champion
        $champion->setPosition($mapSelect);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($champion);
        $manager->flush();

        return $this->render('dynamic_map/index.html.twig', [
            'champion' => $champion,
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
