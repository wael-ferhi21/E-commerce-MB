<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuiSommesNousController extends AbstractController
{
    #[Route('/qui-sommes-nous', name: 'app_qui_sommes_nous')]
    public function index(CategorieRepository $categorieRepository){
        $categorieslist = $categorieRepository->findAll();

        return $this->render('qui_sommes_nous/index.html.twig', [
            'categorieslist' => $categorieslist,
        ]);
    }
}
