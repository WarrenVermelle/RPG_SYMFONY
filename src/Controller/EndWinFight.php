<?php

namespace App\Controller;

use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class EndWinFight extends AbstractController
{
    /**
     * Undocumented function
     *
     * @Route("/game/win", name="win")
     */
    public function winFight(Request $request)
    {
        $session = $request->getSession();
        $manager = $this->getDoctrine()->getManager();
       
        return $this->render('fight/endWinFight.html.twig',[   
            'item' => $manager->find(Item::class, $session->get('loot')->getItem()->getId()),
            'xpFight' => $session->get('xpFight'),
            'goldFight' => $session->get('goldFight'),
            'champion' => $session->get('championActif')
        ]);
    }
}