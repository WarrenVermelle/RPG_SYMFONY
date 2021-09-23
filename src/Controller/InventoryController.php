<?php

namespace App\Controller;

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
    
        return $this->render('inventory/inventory.html.twig',[
            'inventory' => $champion->getInventories()->getValues()
        ]);
    }

    /**
     * @Route("inventory/{id}/equip", name="equip_item")
     */
    public function equipItem($id, InventoryRepository $inventoryRepo, ChampionRepository $championRepo)
    {
        $champion = $championRepo->findOneBy([
            'player' => $this->getUser(),
            //'active' => true
        ]);
        $clickedInventoryLine = $inventoryRepo->findOneBy([
            'id' => $id
        ]);
        $equipedList = $inventoryRepo->findBy([
            'equiped' => true
        ]);
        

        // si élément cliqué n'est pas équipé
        if($clickedInventoryLine->getEquiped() === false)
        {
            // on compare dans la liste des élèments equipés
            foreach($equipedList as $item)
            {
                // si l'élément cliqué est du même type qu'un équipement déjà équipé
                if($item->getItem()->getType()->getId() === $clickedInventoryLine->getItem()->getType()->getId())
                {
                    // déséquipe l'élément déjà équipé
                    $item->setEquiped(false);

                    // enleve les caract de l'ancien élément
                    $champion->setHp($champion->getHp() - $item->getItem()->getHp());
                    $champion->setMp($champion->getMp() - $item->getItem()->getMp());
                    $champion->setIntel($champion->getIntel() - $item->getItem()->getIntel());
                    $champion->setStrength($champion->getStrength() - $item->getItem()->getStrength());
                    $champion->setAgi($champion->getAgi() - $item->getItem()->getAgi());

                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($item);
                    $manager->persist($champion);
                    $manager->flush();
                }
            }

            // équipe l'élément cliqué
            $clickedInventoryLine->setEquiped(true);

            // ajoute les caract de l'élément cliqué
            $champion->setHp($champion->getHp() + $clickedInventoryLine->getItem()->getHp());
            $champion->setMp($champion->getMp() + $clickedInventoryLine->getItem()->getMp());
            $champion->setIntel($champion->getIntel() + $clickedInventoryLine->getItem()->getIntel());
            $champion->setStrength($champion->getStrength() + $clickedInventoryLine->getItem()->getStrength());
            $champion->setAgi($champion->getAgi() + $clickedInventoryLine->getItem()->getAgi());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($clickedInventoryLine);
            $manager->flush();

            // si l'élément cliqué est une potion
            if($clickedInventoryLine->getItem()->getType()->getType() === 'potion')
            {
                // supprime la ligne inventaire
                $manager = $this->getDoctrine()->getManager();
                $champion->removeInventory($clickedInventoryLine,$manager);
                $manager->persist($champion);
                $manager->flush();
            }
        }
        // si l'élément cliqué est équipé
        else
        {
            // déséquipe l'élément cliqué
            $clickedInventoryLine->setEquiped(false);

            // enlève les caract de l'élément cliqué
            $champion->setHp($champion->getHp() - $clickedInventoryLine->getItem()->getHp());
            $champion->setMp($champion->getMp() - $clickedInventoryLine->getItem()->getMp());
            $champion->setIntel($champion->getIntel() - $clickedInventoryLine->getItem()->getIntel());
            $champion->setStrength($champion->getStrength() - $clickedInventoryLine->getItem()->getStrength());
            $champion->setAgi($champion->getAgi() - $clickedInventoryLine->getItem()->getAgi());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($clickedInventoryLine);
            $manager->persist($champion);
            $manager->flush();
        }
        return $this->redirectToRoute('show_inventory');
    }
}