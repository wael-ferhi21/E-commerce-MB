<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categorieslist = $categorieRepository->findAll();

        return $this->render('account/index.html.twig', [
            'categorieslist' =>$categorieslist,

        ]

        );
    }
}
