<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Repository\ChampionRepository;
use App\Repository\InventoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    /**
     * @Route("inventory", name="show_inventory")
     */
    public function showInventory(ChampionRepository $championRepo): Response
    {
        $champion = $championRepo->findOneBy([
            'player' => $this->getUser(),
            //'active' => true
        ]);
    
        return $this->render('default/inventory.html.twig',[
            'inventory' => $champion->getInventories()->getValues()
        ]);
    }

    /**
     * @Route("inventory/{id}/equip", name="equip_item")
     */
    public function equipItem($id, InventoryRepository $inventoryRepo, ChampionRepository $championRepo)
    {
        $inventory = $championRepo->findOneBy([
            'player' => $this->getUser(),
            //'active' => true
        ]);

        $clickedInventoryLine = $inventoryRepo->findOneBy([
            'id' => $id
        ]);
        $equipedList = $inventoryRepo->findBy([
            'equiped' => true
        ]);



        if($clickedInventoryLine->getEquiped() === false)
        {
            $clickedInventoryLine->setEquiped(true);
        }
        else
        {
            foreach ($equipedList as $equipedItem)
            {
                if($equipedItem->getItem()->getType()->getId() === $clickedInventoryLine->getItem()->getType()->getId())
                {
                    $equipedItem->setEquiped(false);
                    $clickedInventoryLine->setEquiped(true);
                }
            }
        }
        



        // if($clickedInventoryLine->getEquiped() === false){
        //     $clickedInventoryLine->setEquiped(true);
        // }else{
        //     $clickedInventoryLine->setEquiped(false);
        // }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($clickedInventoryLine);
        $manager->persist($equipedItem);
        $manager->flush();

        return $this->redirectToRoute('show_inventory');
    }
}