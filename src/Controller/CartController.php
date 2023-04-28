<?php

namespace App\Controller;

use App\Classe\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{  private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart)
    {

    
        return $this->render('cart/index.html.twig', [
            'cart'=>$cart->getFull(),
           
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add_Produits')]
    public function add(Cart $cart ,$id )
    {
        $cart->add($id); 
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(Cart $cart,$id)
    {
        $cart->remove($id);  
        return $this->redirectToRoute('produits');
    }
    #[Route('/cart/delete/{id}', name: 'app_cart_delete')]
    public function delete(Cart $cart,$id)
    {
        $cart->delete($id); 
        return $this->redirectToRoute('app_cart');
    }


    #[Route('/cart/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease(Cart $cart,$id)
    {
        $cart->decrease($id); 
        return $this->redirectToRoute('app_cart');
    }


}
