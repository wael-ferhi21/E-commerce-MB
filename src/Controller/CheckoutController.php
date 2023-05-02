<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{

    #[Route('/checkout', name: 'app_checkout')]
    public function index(Request $request): Response
    {
        // Retrieve the cart from the session
        $cart = $request->getSession()->get('cart', []);

        // Retrieve the selected carrier from the session
        $carrier = $request->getSession()->get('carrier', null);

        // If the cart is empty or the carrier is not selected, redirect to the cart page
        if (empty($cart) || $carrier === null) {
            return $this->redirectToRoute('app_cart');
        }

        // Calculate the total price of the cart
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantité'] * $item['produit']->getPrice();
        }

        // Add the carrier price to the total
        $total += $carrier->getPrice();

        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
            'carrier' => $carrier,
            'total' => $total,
        ]);
    }
}