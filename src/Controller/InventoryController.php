<?php

namespace App\Controller;

use App\Repository\InventoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route ('/game')]
class InventoryController extends AbstractController
{
    #[Route("inventory", name:"show_inventory")]
    public function showInventory(Request $request): Response
    {
        $inventory = $request->getSession()->get('inventory');
    
        return $this->render('inventory/inventory.html.twig',[
            'inventory' => $inventory
        ]);
    }

    #[Route("inventory/{id}/equip", name:"equip_item")]
    public function equipItem($id, Request $request, InventoryRepository $inventoryRepo)
    {
        $champion = $request->getSession()->get('championActif');

        $clickedInventoryLine = $inventoryRepo->findOneBy([
            'id' => $id
        ]);

        $equipedList = $request->getSession()->get('equipedList');
        

        // si élément cliqué n'est pas équipé
        if($clickedInventoryLine->getEquiped() === false)
        {
            if($equipedList){
                // on compare dans la liste des élèments equipés
                foreach($equipedList as $item)
                {
                    // si l'élément cliqué est du même type qu'un équipement déjà équipé
                    if($item->getItem()->getType()->getId() === $clickedInventoryLine->getItem()->getType()->getId())
                    {
                        // déséquipe l'élément déjà équipé
                        $item->setEquiped(false);

                        // enleve les caract de l'ancien élément
                        $champion->setMaxHp($champion->getMaxHp() - $item->getItem()->getHp());
                        $champion->setMaxMp($champion->getMaxMp() - $item->getItem()->getMp());
                        $champion->setIntel($champion->getIntel() - $item->getItem()->getIntel());
                        $champion->setStrength($champion->getStrength() - $item->getItem()->getStrength());
                        $champion->setAgi($champion->getAgi() - $item->getItem()->getAgi());

                        $manager = $this->getDoctrine()->getManager();
                        $manager->persist($item);
                        $manager->persist($champion);
                        $manager->flush();
                    }
                }
            }

            // équipe l'élément cliqué
            $clickedInventoryLine->setEquiped(true);

            // si l'élément cliqué est une potion
            if($clickedInventoryLine->getItem()->getType()->getType() === 'potion')
            {
                // si le champion a perdu des pv ou des pm
                if($champion->getHp() < $champion->getMaxHp() || $champion->getMp() < $champion->getMaxMp())
                {
                    // si la potion de vie donne plus que la vie manquante
                    if($clickedInventoryLine->getItem()->getHp() > ($champion->getMaxHp() - $champion->getHp()))
                    {
                        // remettre au max
                        $champion->setHp($champion->getMaxHp());
                    }
                    // sinon si la potion de mana donne plus que la mana manquante
                    else if($clickedInventoryLine->getItem()->getMp() > ($champion->getMaxMp() - $champion->getMp()))
                    {
                        // remettre au max
                        $champion->setMp($champion->getMaxMp());
                    }
                    // sinon ajouter la valeur de la potion
                    else
                    {
                        $champion->setHp($champion->getHp() + $clickedInventoryLine->getItem()->getHp());
                        $champion->setMp($champion->getMp() + $clickedInventoryLine->getItem()->getMp());
                    }
                    // supprime la ligne de l'inventaire
                    $manager = $this->getDoctrine()->getManager();
                    $champion->removeInventory($clickedInventoryLine,$manager);
                    $manager->persist($champion);
                    $manager->flush();
                }
                // sinon retour à l'inventaire sans utiliser de potion
                return $this->redirectToRoute('show_inventory');
            }
            // sinon on ajoute les caract de l'objet aux stats max
            else
            {
                $champion->setMaxHp($champion->getMaxHp() + $clickedInventoryLine->getItem()->getHp());
                $champion->setMaxMp($champion->getMaxMp() + $clickedInventoryLine->getItem()->getMp());
                $champion->setIntel($champion->getIntel() + $clickedInventoryLine->getItem()->getIntel());
                $champion->setStrength($champion->getStrength() + $clickedInventoryLine->getItem()->getStrength());
                $champion->setAgi($champion->getAgi() + $clickedInventoryLine->getItem()->getAgi());
            }
        }
        // si l'élément cliqué est équipé
        else
        {
            // déséquipe l'élément cliqué
            $clickedInventoryLine->setEquiped(false);

            // enlève les caract de l'élément cliqué
            $champion->setMaxHp($champion->getMaxHp() - $clickedInventoryLine->getItem()->getHp());
            $champion->setMaxMp($champion->getMaxMp() - $clickedInventoryLine->getItem()->getMp());
            $champion->setIntel($champion->getIntel() - $clickedInventoryLine->getItem()->getIntel());
            $champion->setStrength($champion->getStrength() - $clickedInventoryLine->getItem()->getStrength());
            $champion->setAgi($champion->getAgi() - $clickedInventoryLine->getItem()->getAgi());
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($clickedInventoryLine);
        $manager->persist($champion);
        $manager->flush();
        return $this->redirectToRoute('show_inventory');
    }
}