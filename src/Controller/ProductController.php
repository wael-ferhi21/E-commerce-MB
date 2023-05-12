<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\SearchType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
    #[Route('/Nos-produits', name: 'produits')]
    public function index(Request $request)
    {      
        
        $categorieslist=$this->entityManager->getRepository(Categorie::class)->findAll();

        
        $search = new Search(); 
        $form= $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produits=$this->entityManager->getRepository(Produit::class)->findWithSearch($search);
        } else{
            $produits=$this->entityManager->getRepository(Produit::class)->findAll();

        }

        return $this->render('product/index.html.twig', [
            'produits' => $produits,
            'form' => $form->createView(),
            'categorieslist' =>$categorieslist,
        ]);
    }
    #[Route('/produit/{nom}', name: 'produit')]
    public function show($nom)
    {       
        $categorieslist=$this->entityManager->getRepository(Categorie::class)->findAll();
        $produit=$this->entityManager->getRepository(Produit::class)->findOneByNom($nom);
        $produits = $this->entityManager->getRepository(Produit::class)->findByTopVente(1);

        if(!$produit){
            return $this->redirectToRoute('produits');
        }
        
        return $this->render('product/show.html.twig', [
            'produit' => $produit,
            'produits' => $produits,
            'categorieslist' =>$categorieslist,


            
        ]);
    }
}
