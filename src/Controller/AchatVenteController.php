<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Repository\ChampionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game/boutique')]
class AchatVenteController extends AbstractController
{
    #[Route('/achatvente', name: 'achat_vente')]
    public function achatvente(Request $request, ChampionRepository $championRepo): Response
    {
        // prend le champion dans la session
        $session = $request->getSession();

        return $this->render('achat_vente/index.html.twig',
        [
            'controller_name' => 'AchatVenteController',
            'champion' => $session->get('championActif'),
            'InventMarch' => $championRepo->find(1)->getInventories()->getValues(),
            'InventPlayer' => $session->get('nonEquipedList'),
            "affgold" => $session->get('championActif')->getGold()
        ]);
    }

    #[Route('/achat/{id}', name:'achat')]
    public function achat(Request $request, Inventory $item)
    {
        // prend le champion dans la session
        $champion = $request->getSession()->get('championActif');

        if($champion->getGold() >= $item->getItem()->getPrice())
        {
            $champion->addInventory($item);
            $champion->setGold($champion->getGold() - $item->getItem()->getPrice());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($champion);
            $manager->flush();

            return $this->redirectToRoute('achat_vente');
        }
        else
        {
            return $this->redirectToRoute('achat_vente');
        }
    }

    #[Route('/vente/{id}', name:'vente')]
    public function vente(Request $request, Inventory $item)
    {
        // prend le champion dans la session
        $champion = $request->getSession()->get('championActif');

        $champion->setGold($champion->getGold() + $item->getItem()->getPrice()/2);

        $manager = $this->getDoctrine()->getManager();
        $champion->removeInventory($item, $manager);
        $manager->persist($champion);
        $manager->flush();

        return $this->redirectToRoute('achat_vente');
    }
}