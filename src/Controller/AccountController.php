<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Form\CreatePersoType;
use App\Service\CreatePersoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account_index')]
    public function accountIndex(): Response
    {
        return $this->render("account/index.html.twig", []);
    }

    #[Route('/creation/character', name: 'account_create_perso')]
    public function accountCreatePerso(Request $request, CreatePersoService $service): Response
    {
        $champion = new Champion();
        $form = $this->createForm(CreatePersoType::class, $champion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $champion->setPlayer($this->getUser());
            $service->fillChampObj($champion);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($champion);
            $manager->flush();

            return $this->redirectToRoute('account_index');
        }

        return $this->render("account/create-perso.html.twig", ['formPerso' => $form->createView()]);
    }
}