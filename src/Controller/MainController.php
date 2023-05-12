<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categorieslist = $categorieRepository->findAll();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'categorieslist' => $categorieslist,

        ]);
        
        
    }
    
}
