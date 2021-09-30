<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Entity\User;
use App\Form\CreatePersoType;
use App\Service\CreatePersoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'account_index')]
    public function accountIndex(): Response
    {
        return $this->render("account/index.html.twig", 
            [
                "champions" => $this->getUser()->getChampions()->getValues()
            ]);
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

    #[Route('/champion/delete/{id}', name: 'champion_delete', methods: ['POST'])]
    public function delete(Request $request, Champion $champion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$champion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($champion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('account_index', [], Response::HTTP_SEE_OTHER);
    }
}