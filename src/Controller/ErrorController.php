<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error', name:'page_error')]
    public function errorPage(Exception $exception){
        return $this->render('bundle/TwigBundle/Exception/error404.html.twig',[]);
        return $this->redirectToRoute('page_error');
    }
        
    

}