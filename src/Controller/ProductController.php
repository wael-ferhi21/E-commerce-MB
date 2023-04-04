<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/produit', name: 'app_product')]
    public function index(ProduitRepository $produitRepository, CategorieRepository $categoriesRepository): Response
    {

        if(isset($_GET["filter"])){
            if($_GET["filter"] == "all"){
                $produits = $produitRepository->findAll();
            }else{
                $produits = $produitRepository->findBy(array('category' => $_GET["filter"]),array('name' => 'ASC'));
            }
        }else{
            $produits = $produitRepository->findAll();
        }


        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductController',
            'produits' => $produits,
            'categories' => $categoriesRepository->findAll()
        ]);
    }
}
