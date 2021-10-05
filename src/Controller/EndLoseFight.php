<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class EndLoseFight extends AbstractController
{
    /**
     * Undocumented function
     *
     * @Route("/lose", name="lose")
     */
    public function loseFight()
    {
        return $this->render('fight/endLoseFight.html.twig',[]);
    }
}