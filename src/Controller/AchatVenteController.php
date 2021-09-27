<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Entity\Item;
use App\Repository\ChampionRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game/boutique')]
class AchatVenteController extends AbstractController
{
    #[Route('/achatvente', name: 'achat_vente')]
    public function achatvente(ChampionRepository $ChampionRepo): Response
    {
        $Player = $ChampionRepo->findOneBy(["player" => $this -> getUser()]);
        $InventPlayer = $Player->getInventories()->getValues();
        $marchand = $ChampionRepo->find(2);
        $InventMarchand = $marchand->getInventories()->getValues();
         $gold = $Player->getGold();
        

        return $this->render('achat_vente/index.html.twig',[
            'champion' => $ChampionRepo->findOneBy([
                "player" => $this->getUser(),
                "actif" => true
            ]), 
            'controller_name' => 'AchatVenteController',
            'InventMarch' => $InventMarchand,
            'InventPlayer' => $InventPlayer,
            "affgold" => $gold
        ]);
    }

    /**
     * @Route("/achat/{id}", name="achat")
     */
    public function achat(Inventory $item, ChampionRepository $champ)
    {
        $champion = $champ ->findOneBy(["player" => $this -> getUser()]);

        $manager = $this->getDoctrine()->getManager();

        $champion -> addInventory($item);
        $champion->setGold($champion->getGold() - $item->getItem()->getPrice());
        $manager-> persist($champion);
        $manager -> flush();
        return $this->redirectToRoute('achat_vente');

    }

    /**
     * @Route("/vente/{id}", name="vente")
     */
    public function vente(Inventory $item, ChampionRepository $champ)
    {
        $champion = $champ ->findOneBy(["player" => $this -> getUser()]);

        $manager = $this->getDoctrine()->getManager();
        // dd($champion, $manager, $item);
        $champion->setGold($champion->getGold() + $item->getItem()->getPrice()/2);
        $champion -> removeInventory($item, $manager);
        $manager-> persist($champion);
        $manager -> flush();

        return $this->redirectToRoute('achat_vente');
    }

}
