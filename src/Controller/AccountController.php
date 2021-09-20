<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account_index')]
    public function accountIndex(): Response
    {
        return $this->render("account/index.html.twig", []);
    }

    #[Route('/creation/personnage', name: 'account_create_perso')]
    public function accountCreatePerso(): Response
    {
        return $this->render("account/create-perso.html.twig", []);
    }
}