<?php

namespace App\Controller;
use App\Entity\Utilisateur;
use App\Form\ChangePasswordType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class AccountPasswordController extends AbstractController
{
    private $entityManager; 
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
    #[Route('/compte/modifier-mdp', name: 'app_account_password')]
    public function index(Utilisateur $user , Request $request, UserPasswordHasherInterface $userPasswordHasher,UtilisateurRepository $userRepository,string $token)
    {  $user = $userRepository->findOneBy(['resetToken' => $token]);

        if (!$user) {
            throw $this->createNotFoundException();
        }
        if ($request->isMethod('POST')) {
            $token = $request->request->get('_token');

            if (!$this->isCsrfTokenValid('reset_password', $token)) {
                throw new InvalidCsrfTokenException();
            }
        $notification=null;
       
        $form=$this->createForm(ChangePasswordType::class,$user);

        $form=$form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $old_pwd=$form->get('old_password')->getData();

            if($userPasswordHasher->isPasswordValid($user,$old_pwd)){

                $new_pwd = $form->get('new_password')->getData();
                $password=$userPasswordHasher->hashPassword($user,$new_pwd);

                $user->setPassword($password);
               
             
                $this->entityManager->flush();
                $notification='Votre mot de passe a été bien mis à jour.';
                return $this->redirectToRoute('account');
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
}