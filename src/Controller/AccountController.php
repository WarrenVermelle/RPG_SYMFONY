<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Form\CreatePersoType;
use App\Repository\MapRepository;
use App\Repository\ImgPersoRepository;
use App\Service\CreatePersoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'account_index')]
    public function accountIndex(ImgPersoRepository $imgPersoRepo): Response
    {
        $champions = $this->getUser()->getChampions()->getValues();
        foreach($champions as $champion)
        {
            $champion->setCurrentImg($imgPersoRepo->findOneBy([
                'gender' => $champion->getGender(),
                'race' => $champion->getRace(),
                'faction' => $champion->getFaction()
            ]));
        }        
        return $this->render("account/index.html.twig", 
            [
                "champions" => $champions
            ]);
    }

    #[Route('/creation/character', name: 'account_create_perso')]
    public function accountCreatePerso(Request $request, CreatePersoService $service, MapRepository $mapRepo): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $champion = new Champion();
        $form = $this->createForm(CreatePersoType::class, $champion);
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