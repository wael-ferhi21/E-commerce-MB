<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeSuccesController extends AbstractController
{   private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }
    #[Route('/commande/merci/{stripeSessionId}', name: 'app_order_validate')]
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $commande = $this->entityManager->getRepository(Commande::class)->findOnByStripeSessionId($stripeSessionId);

        if(!$commande || $commande->getUser() != $this->getUser()) {
           return $this->redirectToRoute('app_home');
        }
        if(!$commande->getState() == 0){
            //vider la session 'cart'
            $cart->remove();
            //modifier le statut isPaid de notre commande en mettant 1
            $commande->setState(1);
            $this->entityManager->flush();
            //envoyer un email à notre client pour lui confirmer sa commande 
        }


        return $this->render('commande_succes/index.html.twig',[
            'commande' => $commande
        ]);
    }
}
