<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountCommandeController extends AbstractController
{
    
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
    #[Route('/compte/Mes-commandes', name: 'app_account_commande')]
    public function index(): Response
    {
        $commandes = $this->entityManager->getRepository(Commande::class)->findSuccesCommande($this->getUser());
        return $this->render('account/commande.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/compte/Mes-commandes/{reference}', name: 'app_account_commande_show')]
    public function show($reference): Response
    {

        $commande = $this->entityManager->getRepository(Commande::class)->findOneByReference($reference);

        if(!$commande || $commande->getCommandeclient() != $this->getUser()){
            return $this->redirectToRoute('app_account_commande');
        }
        $categorieslist=$this->entityManager->getRepository(Categorie::class)->findAll();

        return $this->render('account/commande_show.html.twig', [
            'commande' => $commande,
            'categorieslist' =>$categorieslist,

        ]);
    }
}
