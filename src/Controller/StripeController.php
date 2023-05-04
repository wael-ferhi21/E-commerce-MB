<?php

namespace App\Controller;

use App\Classe\Cart;
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

    public function index(EntityManagerInterface $entityManager,  Cart $cart, $reference)

    {
        $produits_for_stripe=[]; 
        $YOUR_DOMAIN = 'http://localhost:127.0.0.1:8000';
        
        $commande = $entityManager->getRepository(Commande::class);
        foreach($cart->getFull() as $produit){
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
        
    
        Stripe::setApiKey('sk_test_51N3dd1LMYODaSYBCseG2dBJsKA7vqGJV8WyNl5vGh0lWFEDfIKFqvBfFPnWUKLS40bqt3gTzsIaMXFLdUwknnoID000iAAjdAA');
         
             
        $checkout_session = Session::create([
           'customer_email' =>$this->getUser()->getEmail(),
           'payment_method_types' => ['card'],
           'line_items' =>[
            $produits_for_stripe
           ],
           'mode' => 'payment',
           'success_url' => $YOUR_DOMAIN . '/success.html',
           'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        $response = new JsonResponse(['id'=> $checkout_session->id]);
        return $response;
    }
}