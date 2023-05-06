<?php

namespace App\Controller;

use App\Entity\Header;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
       
        $produits = $this->entityManager->getRepository(Produit::class)->findByTopVente(1);
        $headers=$this->entityManager->getRepository(Header::class)->findAll();
        return $this->render('home/index.html.twig',[
            'produits' => $produits,
            'headers'=>$headers
        ]);
    }
}
