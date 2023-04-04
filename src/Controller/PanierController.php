<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierWithData = [];

        foreach($panier as $id => $nbr_prod) {
            $panierWithData[] = [
                'produit' => $produitRepository->find($id),
                'quantité' => $nbr_prod,
            ];
        }

        $total = 0;

        foreach($panierWithData as $items){
            $totalItem = $items["produit"]->getPrix() * $items["quantity"];
            $total += $totalItem;
        }

        return $this->render('panier/index.html.twig', [
            "items" => $panierWithData,
            "total" => $total
        ]);
    }

    #[Route('/panier/addProduits/{id}', name: 'app_panier_add_Produits')]
    public function addProduits($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier_index');
    }

    #[Route('/panier/remove/{id}', name: 'app_panier_remove')]
    public function remove($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier_index');
    }

    #[Route('/panier/clear/', name: 'app_panier_clear')]
    public function clear(): Response
    {

        return $this->redirectToRoute('app_panier_index');
    }
}
