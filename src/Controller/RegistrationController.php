<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;



class RegistrationController extends AbstractController
{   private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $notification= null;
        $user = new  Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            
            
        $user=$form->getData();
        $search_email=$this->entityManager->getRepository(Utilisateur::class)->findOneByEmail($user->getEmail());
        if (!$search_email){

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        $email= new Mail();
        $content='Bienvenue'.$user->getNom();
        $email->send($user->getEmail(),$user->getNom(),'Bienvenue',$content);
        $notification='Votre inscription est correcetement déroulé. Vous pouvez dès à présent vous connecter à votre compte.';
      

        }else{
            $notification='email existe déja.';
        }
        
        }
       

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'notification'=>$notification
            
        ]);
    }
}