<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CaracteristiqueController extends AbstractController
{
    #[Route('/caracteristique', name: 'caracteristique')]
    public function index(Request $request): Response
    {
        return $this->render('caracteristique/index.html.twig', [
            'champion' => $request->getSession()->get('championActif')
        ]);
    }
}
