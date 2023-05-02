<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Commande;
use App\Entity\CommandeDetails;

use App\Form\CommandeType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommandeController extends AbstractController

{
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
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



        return $this->render('commande/index.html.twig',[
            'form'=>$form->createView(),
            'cart'=>$cart->getFull()
        ]);
    }
    
    #[Route('/commande/recapitulatif', name: 'app_commande_recap')]
    public function add(Cart $cart,Request $request)
    { 

        $form=$this->createForm(CommandeType::class, null,[
            'user'=> $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date= new DateTimeImmutable();
            $carriers=$form->get('carriers')->getData();
            $adrlivraison=$form->get('adresses')->getData();
            $adrlivraison_content=$adrlivraison->getNom().''.$adrlivraison->getPrenom();
            $adrlivraison_content.= '<br/>'.$adrlivraison->getNumtel();

            if($adrlivraison->getSociete()){
                $adrlivraison_content.= '<br/>'.$adrlivraison->getSociete();
             }
             $adrlivraison_content.= '<br/>'.$adrlivraison->getAdresse();
             $adrlivraison_content.= '<br/>'.$adrlivraison->getCodepostal().''.$adrlivraison->getCite();
             $adrlivraison_content.= '<br/>'.$adrlivraison->getPays();
       
          // Enregistrer ma commande Commande()
          $commande= new Commande();
          $commande->setCommandeclient($this->getUser());
          $commande->setCarrierNom($carriers->getNom());
          $commande->setCreatedAt($date);
          $commande->setCarrierPrix($carriers->getPrix());
          $commande->setAdrlivraison($adrlivraison_content);
          $commande->setIsPaid(0);

          $this->entityManager->persist($commande);
         // Enregistrer mes produits CommandeDetails()

          foreach($cart->getFull() as $produit){

            $commande_details=new CommandeDetails();
            $commande_details-> setCommande($commande);
            $commande_details-> setProduit($produit['produit']->getNom());
            $commande_details-> setQuantite($produit['quantité']);
            $commande_details-> setPrix($produit['produit']->getPrix());
            $commande_details-> setTotal($produit['produit']->getPrix()*$produit['quantité']);
            $this->entityManager->persist($commande_details);
          }
          $this->entityManager->flush();
        }


        return $this->render('commande/add.html.twig',[
            
            'cart'=>$cart->getFull(),
            'carrier'=>$carriers
            
            
        ]);
    }
    
     
    }

