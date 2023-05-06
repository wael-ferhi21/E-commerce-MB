<?php

namespace App\Controller;

use App\Classe\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index()
    {
        $mail=new Mail();
    $mail->send(waelferhi28@gmail.com,'Amal Wafi','First Mail','Bonjour jespére que vous allez bien');
  
        
        
    }
    
}
