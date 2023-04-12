<?php
// src/Controller/ResetPasswordController.php

namespace App\Controller;

use App\Form\ResetPasswordType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class ResetPasswordController extends AbstractController
{
    /**
     * @Route("/reset-password/{token}", name="reset_password")
     */
    public function resetPassword(Request $request, UtilisateurRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, string $token): Response
    {
        $user = $userRepository->findOneBy(['resetToken' => $token]);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        if ($request->isMethod('POST')) {
            $token = $request->request->get('_token');

            if (!$this->isCsrfTokenValid('reset_password', $token)) {
                throw new InvalidCsrfTokenException();
            }

            $form = $this->createForm(ResetPasswordType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());

                $user->setPassword($password);
                $user->setResetToken(null);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Your password has been reset.');

                return $this->redirectToRoute('app_login');
            }
        } else {
            $form = $this->createForm(ResetPasswordType::class, $user);
        }

        return $this->render('reset_password/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

