<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class EndWinFight extends AbstractController
{
    /**
     * Undocumented function
     *
     * @Route("/win", name="win")
     */
    public function winFight()
    {
        return $this->render('fight/endWinFight.html.twig',[]);
    }
}