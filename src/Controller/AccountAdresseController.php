<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdresseController extends AbstractController
{
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
    #[Route('/compte/adresse', name: 'app_adresse')]
    public function index(): Response
    {
        return $this->render('account/adresse.html.twig',);
    }
    
    #[Route('/compte/ajouter-une-adresse', name: 'app_add_adresse')]
    public function add(Cart $cart, Request $request): Response
    {
        $adresse=new Adresse();
        $form=$this->createForm(AdresseType::class,$adresse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $adresse->setAdresseclient($this->getUser());
            $this->entityManager->persist($adresse);
            $this->entityManager->flush();

            
            if($cart->get()){
                return $this->redirectToRoute('app_commande');

            }else{
                return $this->redirectToRoute('app_adresse');

            }
         }

        
        return $this->render('account/adresse_form.html.twig',[
            'form'=> $form->createView()
        ]);
    }
    
    #[Route('/compte/ajouter-une-adresse/modifier/{id}', name: 'app_edit_adresse')]
    public function edit(Request $request, $id): Response
    {
        $adresse=$this->entityManager->getRepository(Adresse::class)->findOneById($id);
        if(!$adresse || $adresse->getAdresseclient() != $this->getUser()){
            return $this->redirectToRoute('app_adresse');

        }

        $form=$this->createForm(AdresseType::class,$adresse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute('app_adresse');


        }
        return $this->render('account/adresse_form.html.twig',[
            'form'=> $form->createView()
        ]);
    }
    #[Route('/compte/supprimer-une-adresse/modifier/{id}', name: 'app_delete_adresse')]
    public function delete( $id): Response
    {
        $adresse=$this->entityManager->getRepository(Adresse::class)->findOneById($id);
        if($adresse && $adresse->getAdresseclient() == $this->getUser()){
            $this->entityManager->remove($adresse);
            $this->entityManager->flush();
        }

         
            return $this->redirectToRoute('app_adresse');


    }


}
