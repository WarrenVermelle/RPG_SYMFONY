<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Monster;
use App\Entity\Type;
use App\Entity\User;
use App\Form\CreateItemType;
use App\Form\CreateMonsterType;
use App\Repository\ItemRepository;
use App\Repository\MonsterRepository;
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

//============================== Block User ==============================

    #[Route('/listusers', name: 'admin_userslist')]
    public function listUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/users/listusers.html.twig', [
            "users" => $userRepository->findAll()
        ]);
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



//============================= Block Monster =============================

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

//============================== Block Type/Item =============================

    #[Route('/listtypes', name: 'admin_items_listItems')]
    public function listItems(ItemRepository $itemRepository, TypeRepository $typeRepository): Response
    {
       // dd($itemRepository->findAll());
        return $this->render('admin/items/listItems.html.twig', [
            "types" => $typeRepository->findAll(),
            "items" => $itemRepository->findAll()
        ]);
    }

    #[Route('/createItem', name: 'admin_items_createItem')]
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

}