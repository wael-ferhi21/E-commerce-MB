<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CommandeCrudController extends AbstractCrudController
{
    
    private $entityManager; 
    private $adminUrlGenerator;
    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator){
        $this->entityManager= $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }


   
    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation= Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open')->linkToCrudAction('updatePreparation');
        $updateLivraison= Action::new('updateLivraison', 'Livraison en cours','fas fa-truck')->linkToCrudAction('updateLivraison');

        return $actions 
        ->add('detail', $updatePreparation)
        ->add('detail', $updateLivraison)
        ->add('index', 'detail');
    }
    
    public function updatePreparation(AdminContext $context ,UrlGeneratorInterface $urlGenerator ){
        $commande =$context->getEntity()->getInstance();
        $commande->setState(2);
        $this->entityManager->flush();
        $this->addFlash('notice', "<span style='color:green;'><strong> La commande ".$commande->getReference()."est bien <u> en cours de préparation</u>.</strong></span>");

        $url = $this->adminUrlGenerator->setController(CommandeCrudController::class)
        ->setAction('index')
        ->generateUrl();

        return $this->redirect($url);   
    }
    public function updateLivraison(AdminContext $context , UrlGeneratorInterface $urlGenerator ){
        $commande =$context->getEntity()->getInstance();
        $commande->setState(3);
        $this->entityManager->flush();
        $this->addFlash('notice', "<span style='color:orange;'><strong> La commande ".$commande->getReference()."est bien <u> en cours de livraison</u>.</strong></span>");

        $url = $this->adminUrlGenerator->setController(CommandeCrudController::class)
        ->setAction('index')
        ->generateUrl();

        return $this->redirect($url); 
    }
    public function  configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }
   
    public function configureFields(string $pageName): iterable
    {
        return [   
        IdField::new('id')->hideOnForm(),      
        DateTimeField::new('createdAt', 'Passé le'),
        TextField::new('commandeclient.getFullName', 'Utilisateur'),
        TextEditorField::new('adrlivraison','Adresse de livraison')->onlyOnDetail(),        
        MoneyField::new('total')->setCurrency('TND'),
        TextField::new('carrierNom', 'Transporteur'),
        MoneyField::new('carrierPrix','frais de port')->setCurrency('TND'),
        ChoiceField::new('state')->setChoices([
            'Non payé' => 0,
            'Payé' => 1,
            'Préparation en cours' => 2, 
            'Livraison en cours' => 3, 
            
        ]),
        ArrayField::new('commandeDetails', 'Produit achetés')->hideOnIndex(),
    ];
    }
    
}
