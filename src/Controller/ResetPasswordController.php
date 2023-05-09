<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ResetPassword;
use App\Entity\Utilisateur;
use App\Form\ResetPasswordType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    #[Route('/mot-de-passe-oublie', name: 'app_reset_password')]
    public function index(Request $request)
    {
    if($this->getUser()){
        return $this->redirectToRoute('app_home');
    }
    if($request->get('email')){
        
        $user = $this->entityManager->getRepository(Utilisateur::class)->findOneByEmail($request->get('email'));

        if($user){
            // 1 : Enregistrer en base la demande de reset_password avec user , token , createdAt
            $reset_password= new ResetPassword();
            $reset_password->setUser($user);
            $reset_password->setToken(uniqid());
            $reset_password->setCreatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($reset_password);
            $this->entityManager->flush();
    

           // 2 : Envoyer un email à l'utilisateur avec un lien lui permettant de mettre à jour son mot de passe.

             $url = $this->generateUrl('app_update_password',[
            'token' => $reset_password->getToken()
            ]);

           $content="Bonjour".$user->getNom()."<br/>Vous avez demandé à réinitialiser votre mot de passe. <br/><br/>";
           $content .= "Merci de bien vouloir cliquer sur le lien suivant pour <a href='" . $url . "' > mettre à jour votre mot de passe</a>.";
           $mail = new Mail();
           $mail->send($user->getEmail(), $user->getNom().' '.$user->getPrenom(), 'Réinitialiser votre mot de passe ', $content);
           $this->addFlash('notice', 'Vous allez recevoir dans quelques secondes un mail avec la procédure pour réinitialiser votre mot de passe.');

        }else {

            $this->addFlash('notice', 'Cette adresse email est inconnue.');

        }

    }
    
        return $this->render('reset_password/index.html.twig');
    }
    
    #[Route('/mot-de-passe-oublie/{token}', name: 'app_update_password')]
    public function update(Request $request,$token,UserPasswordHasherInterface $userPasswordHasher)
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        
       if (!$reset_password){
        return $this->redirectToRoute('app_reset_password');
       } 
       // Vérifier si le createAt = now 3h
       $now = new \DateTimeImmutable();
       if($now > $reset_password->getCreateAt()->modify('+ 3 hour')) { 
        $this->addFlash('notice', 'Votre dedmande de mot de passe a expiré. Merci de la controller.');
        return $this->redirectToRoute('app_reset_password');
       }

       // Rendre une vue avec mot de passe et confirmer votre mot de passe.
       $form = $this->createForm(ResetPasswordType::class);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
        $new_pwd = $form->get('new_password')->getData();
        // Encodage des mots de passe 
        $password=$userPasswordHasher->hashPassword($reset_password->getUser(),$new_pwd);
        $reset_password->getUser()->setPassword($password);
        // flush en base de donnée.
        $this->entityManager->flush();
        // Redirection de l'utilisateur vers la page de connexion.
        $this->addFlash('notice', 'Votre mot de passe a bien été mis à jour.');
         
        return $this->redirectToRoute('app_login');

       }

       return $this->render('reset_password/update.html.twig', [
        'form' => $form->createView()
       ]);

     }
    

    }
