<?php

namespace App\Controller;

use App\Repository\MapRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Route('/game/voyage')]
class DynamicMapController extends AbstractController
{
    //#[Route('/{id}', name: 'dynamic_map')]
    public function index($id, MapRepository $mapRepo): Response
    {
        // dd($mapRepo);

        return $this->render('dynamic_map/index.html.twig', [
            'controller_name' => 'DynamicMapController',
        ]);
    }
}
