<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeCancelController extends AbstractController
{
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }
    #[Route('/commande/erreur/{stripeSessionId}', name: 'app_commande_cancel')]
    public function index($stripeSessionId): Response
    {
        
        $commande = $this->entityManager->getRepository(Commande::class)->findOnByStripeSessionId($stripeSessionId);

        if(!$commande || $commande->getUser() != $this->getUser()) {
           return $this->redirectToRoute('app_home');
        }

        return $this->render('commande_cancel/index.html.twig',[
            'commande' => $commande
        ]);
    }
}
