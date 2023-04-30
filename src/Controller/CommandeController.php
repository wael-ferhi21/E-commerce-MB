<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(Cart $cart,Request $request): Response
    {
        if(!$this->getUser()->getAdresses()->getValues())
        {
            return $this->redirectToRoute('app_add_adresse');
        }

        $form=$this->createForm(CommandeType::class, null,[
            'user'=>$this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }


        return $this->render('commande/index.html.twig',[
            'form'=>$form->createView(),
            'cart'=>$cart->getFull()
        ]);
    }
}
