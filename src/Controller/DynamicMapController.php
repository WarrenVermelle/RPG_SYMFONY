<?php

namespace App\Controller;

use App\Entity\Monster;
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
        $monsters = $monsterRepo->findAll();
        $monster= $monsters[rand(0,count($monsters)-1)];

        $session = $request->getSession();
        if($session->get('monster') instanceof Monster)
        {
            $session->remove('monster');
            $session->remove('monsterLoots');
        }

        // passe le monstre et son loot dans la session
        $session->set('monster', $monster);
        $session->set('monsterLoots', $monster->getLoots()->getValues());

        // champion connecté
        $champion = $session->get('championActif');
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
