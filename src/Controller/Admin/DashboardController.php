<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){

    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url=$this->adminUrlGenerator
        ->setController(ProduitCrudController::class)
        ->generateUrl();
        return $this->redirect($url);

      
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('website');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('E-commerce');
        yield MenuItem::section('Produits');
        yield MenuItem::subMenu('Gérer','fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter Produit','fas fa-plus',Produit::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Consulter Produit','fas fa-eye',Produit::class)
        ]);
        yield MenuItem::subMenu('Catégories','fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter Catégorie','fas fa-plus',Categorie::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Consulter Catégorie','fas fa-eye',Categorie::class)
        ]);
        
    }
}
