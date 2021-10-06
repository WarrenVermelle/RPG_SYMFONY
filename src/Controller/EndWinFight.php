<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Loot;
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
        $item = ' ';
       
        if($session->get('loot') && $session->get('loot') instanceof Loot)
        {
            $item = $manager->find(Item::class, $session->get('loot')->getItem()->getId());
        }

        return $this->render('fight/endWinFight.html.twig',[   
            'item' => $item,
            'xpFight' => $session->get('xpFight'),
            'goldFight' => $session->get('goldFight'),
            'champion' => $session->get('championActif')
        ]);
    }
}