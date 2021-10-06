<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Entity\Gender;
use App\Entity\ImgPerso;
use App\Entity\Item;
use App\Entity\Monster;
use App\Entity\Race;
use App\Entity\Type;
use App\Entity\User;
use App\Form\CreateFactionType;
use App\Form\CreateGenderType;
use App\Form\CreateImgPersoType;
use App\Form\CreateItemType;
use App\Form\CreateMonsterType;
use App\Form\CreateRaceType;
use App\Form\CreateTypeType;
use App\Form\EditUserType;
use App\Repository\FactionRepository;
use App\Repository\GenderRepository;
use App\Repository\ImgPersoRepository;
use App\Repository\ItemRepository;
use App\Repository\MonsterRepository;
use App\Repository\RaceRepository;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

//============================== Block User ================================

    #[Route('/listusers', name: 'admin_userslist')]
    public function listUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/users/listusers.html.twig', [
            "users" => $userRepository->findAll()
        ]);
    }

    #[Route('/users/edit/{id}', name: 'user_edit', methods: ['POST', 'GET'])]
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $user->setRoles([$form["roles"]->getData()]);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('admin_userslist');
        }

        return $this->render('admin/users/edit_user.html.twig', ['form' => $form->createView()]);

    } 

    #[Route('/user/delete/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_userslist', [], Response::HTTP_SEE_OTHER);
    }



//============================== Block Monster =============================

    #[Route('/listMonster', name:'admin_listMonster')]
    public function listMonster(MonsterRepository $monster): Response
    {
       return $this->render('admin/monsters/listMonster.html.twig', [
            'monsters' => $monster->findAll()
        ]);
    }

    #[Route('/createMonster', name: 'admin_createMonster')]
    public function createMonster(Request $request):Response
    {
        $monster = new Monster();
        $form = $this->createForm(CreateMonsterType::class, $monster);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($monster);
            $manager->flush();

            return $this->redirectToRoute('admin_listMonster');
        }

        return $this->render('admin/monsters/create-monster.html.twig', ['formMonster' => $form->createView()]);
    }

    #[Route('/monster/edit/{id}', name: 'monster_edit', methods: ['POST', 'GET'])]
    public function editMonster(Request $request, Monster $monster): Response
    {
        $form = $this->createForm(CreateMonsterType::class, $monster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($monster);
            $manager->flush();

            return $this->redirectToRoute('admin_listMonster');
        }

        return $this->render('admin/monsters/edit_monster.html.twig', ['formMonster' => $form->createView()]);

    } 

    #[Route('/monster/delete/{id}', name: 'monster_delete', methods: ['POST'])]
    public function deleteMonster(Request $request, Monster $monster): Response
    {
        if ($this->isCsrfTokenValid('delete'.$monster->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($monster);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_listMonster', [], Response::HTTP_SEE_OTHER);
    }

//============================== Block Type/Item ===========================

    #[Route('/listtypes', name: 'admin_items_listItems')]
    public function listItems(ItemRepository $itemRepository, TypeRepository $typeRepository): Response
    {
       // dd($itemRepository->findAll());
        return $this->render('admin/items/listItems.html.twig', [
            "types" => $typeRepository->findAll(),
            "items" => $itemRepository->findAll()
        ]);
    }

    #[Route('/items/createItem', name: 'admin_items_createItem')]
    public function createItem(Request $request):Response
    {
        $item = new Item();
        $form = $this->createForm(CreateItemType::class, $item);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($item);
            $manager->flush();

            return $this->redirectToRoute('admin_items_listItems');
        }

        return $this->render('admin/items/create-item.html.twig', ['formItem' => $form->createView()]);
    }

    #[Route('/types/createType', name: 'admin_items_createType')]
    public function createType(Request $request):Response
    {
        $type = new Type();
        $form = $this->createForm(CreateTypeType::class, $type);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($type);
            $manager->flush();

            return $this->redirectToRoute('admin_items_listItems');
        }

        return $this->render('admin/items/create-type.html.twig', ['formType' => $form->createView()]);
    }

    #[Route('/type/edit/{id}', name: 'type_edit', methods: ['POST', 'GET'])]
    public function editType(Request $request, Type $type): Response
    {
        $form = $this->createForm(CreateTypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($type);
            $manager->flush();

            return $this->redirectToRoute('admin_listType');
        }

        return $this->render('admin/items/edit_type.html.twig', ['formType' => $form->createView()]);

    }

    #[Route('/item/edit/{id}', name: 'item_edit', methods: ['POST', 'GET'])]
    public function editItem(Request $request, Item $item): Response
    {
        $form = $this->createForm(CreateItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($item);
            $manager->flush();

            return $this->redirectToRoute('admin_items_listItems');
        }

        return $this->render('admin/items/edit_item.html.twig', ['formItem' => $form->createView()]);

    } 

    #[Route('/type/delete/{id}', name: 'type_delete', methods: ['POST'])]
    public function deleteType(Request $request, Type $type): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($type);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_items_listItems', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/item/delete/{id}', name: 'item_delete', methods: ['POST'])]
    public function deleteItem(Request $request, Item $item): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_items_listItems', [], Response::HTTP_SEE_OTHER);
    }



//============================== Block Faction =============================
    #[Route('/listfaction', name: 'admin_listFaction')]
    public function listFactions(FactionRepository $factionRepository): Response
    {
        return $this->render('admin/faction/listFactions.html.twig', [
            "factions" => $factionRepository->findAll()
        ]);
    }

    #[Route('/createFaction', name: 'admin_createFaction')]
    public function createFaction(Request $request):Response
    {
        
        $faction = new Faction();
        $form = $this->createForm(CreateFactionType::class, $faction);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($faction);
            $manager->flush();

            return $this->redirectToRoute('admin_listFaction');
        }

        return $this->render('admin/faction/create-faction.html.twig', ['formFaction' => $form->createView()]);
    }

    #[Route('/faction/edit/{id}', name: 'faction_edit', methods: ['POST', 'GET'])]
    public function editFaction(Request $request, Faction $faction): Response
    {
        $form = $this->createForm(CreateFactionType::class, $faction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($faction);
            $manager->flush();

            return $this->redirectToRoute('admin_listFaction');
        }

        return $this->render('admin/faction/edit_faction.html.twig', ['formFaction' => $form->createView()]);

    } 

    #[Route('/faction/delete/{id}', name: 'faction_delete', methods: ['POST'])]
    public function deleteFaction(Request $request, Faction $faction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$faction->getId(), $request->request->get('_token')))
        {
            $imgs = $faction->getImgPersos()->getValues();
            foreach($imgs as $img)
            {
                $img->setImg("");
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($faction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_listFaction', [], Response::HTTP_SEE_OTHER);
    }

//============================== Block Race ================================

    #[Route('/listrace', name: 'admin_listRace')]
    public function listRaces(RaceRepository $raceRepository): Response
    {
        return $this->render('admin/race/listRaces.html.twig', [
            "races" => $raceRepository->findAll()
        ]);
    }

    #[Route('/createRace', name: 'admin_createRace')]
    public function createRace(Request $request):Response
    {
        
        $race = new Race();
        $form = $this->createForm(CreateRaceType::class, $race);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($race);
            $manager->flush();

            return $this->redirectToRoute('admin_listRace');
        }

        return $this->render('admin/race/create-race.html.twig', ['formRace' => $form->createView()]);
    }

    #[Route('/race/edit/{id}', name: 'race_edit', methods: ['POST', 'GET'])]
    public function editRace(Request $request, Race $race): Response
    {
        $form = $this->createForm(CreateRaceType::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($race);
            $manager->flush();

            return $this->redirectToRoute('admin_listRace');
        }

        return $this->render('admin/race/edit_race.html.twig', ['formRace' => $form->createView()]);

    } 

    #[Route('/race/delete/{id}', name: 'race_delete', methods: ['POST'])]
    public function deleteRace(Request $request, Race $race): Response
    {
        if ($this->isCsrfTokenValid('delete'.$race->getId(), $request->request->get('_token')))
        {
            $imgs = $race->getImgPersos()->getValues();
            foreach($imgs as $img)
            {
                $img->setImg("");
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($race);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_listRace', [], Response::HTTP_SEE_OTHER);
    }

//============================== Block Genre ===============================
    #[Route('/listgenders', name: 'admin_listGender')]
    public function listGenders(GenderRepository $genderRepository): Response
    {
        return $this->render('admin/gender/listGenders.html.twig', [
            "genders" => $genderRepository->findAll()
        ]);
    } 
    
    #[Route('/createGender', name: 'admin_createGender')]
    public function createGender(Request $request):Response
    {
        
        $gender = new Gender();
        $form = $this->createForm(CreateGenderType::class, $gender);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($gender);
            $manager->flush();

            return $this->redirectToRoute('admin_listGender');
        }

        return $this->render('admin/gender/create-gender.html.twig', ['formGender' => $form->createView()]);
    }

    #[Route('/gender/edit/{id}', name: 'gender_edit', methods: ['POST', 'GET'])]
    public function editGender(Request $request, Gender $gender): Response
    {
        $form = $this->createForm(CreateGenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($gender);
            $manager->flush();

            return $this->redirectToRoute('admin_listGender');
        }

        return $this->render('admin/gender/edit_gender.html.twig', ['formGender' => $form->createView()]);

    } 

    #[Route('/gender/delete/{id}', name: 'gender_delete', methods: ['POST'])]
    public function deleteGender(Request $request, Gender $gender): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gender->getId(), $request->request->get('_token')))
        {
            $imgs = $gender->getImgPersos()->getValues();
            foreach($imgs as $img)
            {
                $img->setImg("");
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gender);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_listGender', [], Response::HTTP_SEE_OTHER);
    }

//============================== Block ImgPerso ============================
    #[Route('/listimgPerso', name: 'admin_listImgPerso')]
    public function listImgPerso(ImgPersoRepository $imgPersoRepository): Response
    {
        return $this->render('admin/imgPerso/listImgPerso.html.twig', [
            "imgPersos" => $imgPersoRepository->findAll()
        ]);
    } 

    #[Route('/createImgPerso', name: 'admin_createImgPerso')]
    public function createImgPerso(Request $request):Response
    {
        
        $imgPerso = new ImgPerso();
        $form = $this->createForm(CreateImgPersoType::class, $imgPerso);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) 
        {   
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($imgPerso);
            $manager->flush();

            return $this->redirectToRoute('admin_listImgPerso');
        }

        return $this->render('admin/imgPerso/create-imgPerso.html.twig', ['formImgPerso' => $form->createView()]);
    }

    #[Route('/imgPerso/edit/{id}', name: 'imgPerso_edit', methods: ['POST', 'GET'])]
    public function editImgPerso(Request $request, ImgPerso $imgPerso): Response
    {
        $form = $this->createForm(CreateImgPersoType::class, $imgPerso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $imgPerso->setImg("");
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($imgPerso);
            $manager->flush();

            return $this->redirectToRoute('admin_listImgPerso');
        }

        return $this->render('admin/imgPerso/edit_imgPerso.html.twig', ['formImgPerso' => $form->createView()]);

    } 

    #[Route('/imgPerso/delete/{id}', name: 'imgPerso_delete', methods: ['POST'])]
    public function deleteImgPerso(Request $request, ImgPerso $imgPerso): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imgPerso->getId(), $request->request->get('_token')))
        {
            $imgPerso->setImg("");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imgPerso);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_listImgPerso', [], Response::HTTP_SEE_OTHER);
    }




}