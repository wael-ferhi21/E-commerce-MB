<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{reference}', name: 'app_stripe_create_session')]

    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference)
    {
        $produits_for_stripe=[]; 
        $YOUR_DOMAIN =  "https://www.example.com";
            
        $commande = $entityManager->getRepository(Commande::class)->findOneByReference($reference);
            
        if(!$commande) {
            // handle the case where $commande is null, e.g. return an error response
           return new JsonResponse(['error'=> 'commande']);
        }
    
        foreach($cart->getFull() as $produit) {
            $produits_for_stripe[]=[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $produit['produit']->getPrix(),
                    'product_data' => [
                        'name'=>$produit['produit']->getNom(),
                        'images' => [$YOUR_DOMAIN."/upload/image/produit".$produit['produit']->getImage()],
                    ],
                ],
                'quantity'=>$produit['quantité'],
            ]; 
        }
    
        $produits_for_stripe[]=[
           'price_data' => [
               'currency' => 'eur',
               'unit_amount' => $commande->getCarrierPrix() ,
               'product_data' => [
                   'name'=>$commande->getCarrierNom(),
                   'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity'=> 1,
         ]; 
            
        
        Stripe::setApiKey('sk_test_51N3dd1LMYODaSYBCseG2dBJsKA7vqGJV8WyNl5vGh0lWFEDfIKFqvBfFPnWUKLS40bqt3gTzsIaMXFLdUwknnoID000iAAjdAA');
             
                 
        $checkout_session = Session::create([
           'customer_email' =>$this->getUser()->getEmail(),
           'payment_method_types' => ['card'],
           'line_items' => $produits_for_stripe,
           'mode' => 'payment',
           'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
           'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);
         
        $commande->setStripeSessionId($checkout_session->id);
        $entityManager->flush();
        $response = new JsonResponse(['id'=> $checkout_session->id]);
        return $response;
    }
    
}
