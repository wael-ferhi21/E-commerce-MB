<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdresseController extends AbstractController
{
    #[Route('/compte/adresse', name: 'app_adresse')]
    public function index(): Response
    {
        return $this->render('account/adresse.html.twig',);
    }
}
