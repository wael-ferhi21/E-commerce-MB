<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation= Action::new('updatePreparation', 'Préparation en cours')->linkToCrudAction('updatePreparation');
        return $actions 
        ->add('detail', $updatePreparation)
        ->add('index', 'detail');
    }
    public function updatePreparation(){
        
    }
    public function configureFields(string $pageName): iterable
    {
        return [   
        IdField::new('id')->hideOnForm(),      
        DateTimeField::new('createdAt', 'Passé le'),
           
        TextField::new('commandeclient.getFullName', 'Utilisateur'),
        MoneyField::new('total')->setCurrency('TND'),
        ChoiceField::new('state')->setChoices([
            'Non payé' => 0,
            'Payé' => 1,
            'Préparation en cours' => 2, 
            'Livraison en cours' => 3, 
            
        ]),
        TextEditorField::new('description'),
    ];
    }
    
}
