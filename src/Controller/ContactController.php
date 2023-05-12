<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/nous-contacter', name: 'app_contact')]
    public function index(Request $request,CategorieRepository $categorieRepository): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $this->addFlash('notice', 'Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais.');
        }
        $categorieslist = $categorieRepository->findAll();

        return $this->render('contact/index.html.twig',[
            'form' => $form->createView(),
            'categorieslist' => $categorieslist,
            ]
        );
    }
}
