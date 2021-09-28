<?php

namespace App\Controller;

use App\Repository\ChampionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaracteristiqueController extends AbstractController
{
    #[Route('/caracteristique', name: 'caracteristique')]
    public function index(ChampionRepository $championRepository): Response
    {
        return $this->render('caracteristique/index.html.twig', [
            'champion'=>$championRepository->findOneBy([
                'player' => $this->getUser(),
                'actif' => true])
        ]);
    }
}
