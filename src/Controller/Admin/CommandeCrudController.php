<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
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
        return $actions 
        ->add('index', 'detail');
    }
    public function configureFields(string $pageName): iterable
    {
        return [   
        IdField::new('id')->hideOnForm(),      
        DateTimeField::new('createdAt', 'Passé le'),
           
        TextField::new('commandeclient.getFullName', 'Utilisateur'),
        MoneyField::new('total')->setCurrency('TND'),
        BooleanField::new('isPaid','Payée'),
        TextEditorField::new('description'),
    ];
    }
    
}
