<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\MonsterRepository;
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

    #[Route('/listusers', name: 'admin_userslist')]
    public function listUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/listusers.html.twig', [
            "users" => $userRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('account_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/listMonster', name:'admin_listMonster')]
    public function listMonster(MonsterRepository $monster): Response
    {
        $monster[] = $monster->findAll();
       return $this->render('admin/listMonster.html.twig', [
            'monsters' => $monster
        ]);
    }

    // #[Route('/createMonster', name: 'admin_createMonster')]
    // public function createMonster():Response
    // {

    // }
}
