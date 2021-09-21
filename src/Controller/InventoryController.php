<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Entity\User;
use App\Repository\ChampionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    /**
     * @Route("inventory", name="showInventory")
     */
    public function showInventory(ChampionRepository $championRepo): Response
    {
        return $this->render('default/inventory.html.twig',[
            'inventory' => dd($championRepo->findAll())
        ]);
    }
}