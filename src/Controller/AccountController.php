<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Entity\Faction;
use App\Entity\Race;
use App\Entity\User;
use App\Form\CreatePersoType;
use App\Repository\FactionRepository;
use App\Repository\MapRepository;
use App\Service\CreatePersoService;
use App\Service\ChampionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotNull;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'account_index')]
    public function accountIndex(ChampionService $service): Response
    {
        $champions = $this->getUser()->getChampions()->getValues();
        foreach ($champions as $champion) {
           $champion->setCurrentImage($service->getTrueImgProperty($champion));
        }
        return $this->render("account/index.html.twig", 
            [
                "champions" => $champions
            ]);
    }

    #[Route('/creation/character', name: 'account_create_perso')]
    public function accountCreatePerso(Request $request, CreatePersoService $service, ChampionService $chpService, MapRepository $mapRepo): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $champion = new Champion();
        $form = $this->createForm(CreatePersoType::class, $champion);

        if(!is_null($champion->getGender()) && !is_null($champion->getRace()))
        {
            $champion->setCurrentImage($chpService->getTrueImgProperty($champion));
        }
        elseif (!is_null($champion->getGender()) && !is_null($champion->getRace()) && !is_null($champion->getFaction())) {
            $champion->setCurrentImage($chpService->getTrueImgProperty($champion));
        }

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {

            $champion->setPlayer($this->getUser());
            $service->fillChampObj($champion);
            // fait démarrer dans la ville
            $champion->setPosition($mapRepo->findOneBy(['id' => 1]));
            
            $manager->persist($champion);
            $manager->flush();

            return $this->redirectToRoute('account_index');
        }

        return $this->render("account/create-perso.html.twig", ['formPerso' => $form->createView(), 'champion' => $champion]);
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