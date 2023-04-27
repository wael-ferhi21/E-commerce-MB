<?php

namespace App\Classe;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart extends AbstractController
{
    private $session;
    private $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->session = $requestStack->getSession();
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
{
    $cart = $this->session->get('cart', []);
    if ($id !== null && isset($cart[$id])) {
        unset($cart[$id]);
    }
    $this->session->set('cart', $cart);
}
public function decrease($id)
{
    $cart = $this->session->get('cart', []);
    if ($id !== null && isset($cart[$id]))  {
        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }
        $this->session->set('cart', $cart);
    }
}

    public function getFull()
    {
        $cartComplete = [];

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $produit_object = $this->entityManager->getRepository(Produit::class)->findOneById($id);
                if (!$produit_object) {
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'produit' => $produit_object,
                    'quantité' => $quantity,
                ];
            }
        }

        return $cartComplete;
    }
}
