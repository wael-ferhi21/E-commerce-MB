<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,CategorieRepository $categorieRepository): Response
    {
        if ($this->getUser()) {
         return $this->redirectToRoute('app_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $categorieslist = $categorieRepository->findAll();


        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'categorieslist' => $categorieslist,

        ]);
    }
    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(AuthenticationUtils $authenticationUtils, CategorieRepository $categorieRepository, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        if ($this->getUser()) {
            return new JsonResponse(['message' => $authenticationUtils->getLastUsername()]);
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $categoriesList = $categorieRepository->findAll();

        // Replace this with your own logic to retrieve the user based on the username
        $user = $this->getUser();

        if ($this->getUser()) {
            return new JsonResponse(['message' => 'Invalid credentials.']);
        }

        $token = $jwtManager->create($this->getUser());

        return new JsonResponse([
            'token' => $token,
            'user' => $lastUsername,
            'categoriesList' => $categoriesList,
        ]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
