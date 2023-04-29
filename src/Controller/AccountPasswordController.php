<?php

namespace App\Controller;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
    #[Route('/compte/modifier-mdp', name: 'app_password')]
    public function index( Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $notification=null;
        $user = $this->getUser();
       
        $form=$this->createForm(ChangePasswordType::class,$user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $old_pwd=$form->get('old_password')->getData();

            if($userPasswordHasher->isPasswordValid($user,$old_pwd)){

                $new_pwd = $form->get('new_password')->getData();
                $password=$userPasswordHasher->hashPassword($user,$new_pwd);

                $user->setPassword($password);
               
             
                $this->entityManager->flush();
                $notification='Votre mot de passe a été bien mis à jour.';
                return $this->redirectToRoute('app_account');
            }
            else{
                $notification="Votre actuel n'est pas le bon";
                $form = $this->createForm(ResetPasswordType::class, $user);
            }
        }
        return $this->render('account/password.html.twig',[
            'form'=>$form->createView(),
            'notification' => $notification
        ]);
    }
}
