<?php

namespace App\Controller;

use App\Repository\ChampionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChampionController extends AbstractController
{
    #[Route('/champion', name: 'champion')]
    public function index(ChampionRepository $championRepository): Response
    {
       // dd($championRepository->find(1));
        $champion = $championRepository->find(1);
        return $this->render('game/footer.html.twig', [
            'controller_name' => 'ChampionController',
            'champion'=>$champion]);
    }
}
