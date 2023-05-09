<?php

namespace App\Controller\Admin;

use App\Entity\SousCategorie;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SousCategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SousCategorie::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom de la sous catégorie'),
            DateTimeField::new('updatedAt', 'Mis à jour le :'),
            DateTimeField::new('createdAt', 'Créé le :'),
            AssociationField::new('cat', 'Catégorie'),
            ImageField::new('image', 'Image')
                ->setBasePath('upload\image\produit')
                ->setUploadDir('public\upload\image\produit')
                ->setSortable(false),
        ];
    }
    public function persistEntity(EntityManagerInterface  $em , $entityInstance): void
    {
        if(!$entityInstance instanceof SousCategorie) return;

        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        
        parent::persistEntity($em,$entityInstance);

    }
    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof SousCategorie) {
            return;
        }
    
        $categorie = $entityInstance->getCat();
        if ($categorie) {
            $em->remove($categorie);
        }
    
        parent::deleteEntity($em, $entityInstance);
    }
    
    }
    
