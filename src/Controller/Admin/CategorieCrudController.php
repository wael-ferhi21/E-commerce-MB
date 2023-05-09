<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('catlib','Nom de la catégorie'),
            DateTimeField::new('updatedAt','Mis a jour le:'),
            DateTimeField::new('createdAt','Crée le :'),
            ImageField::new('image','Image')
            ->setBasePath('upload\image\produit')
            ->setUploadDir('public\upload\image\produit')
            ->setFormTypeOptions(['mapped' => false , 'required' => false])
            ->setSortable(false),
            
        ];
    }
    public function persistEntity(EntityManagerInterface  $em , $entityInstance): void
    {
        if(!$entityInstance instanceof Categorie) return;

        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        
        parent::persistEntity($em,$entityInstance);

    }
    public function deleteEntity(EntityManagerInterface $em,$entityInstance ):void
    {
        if(!$entityInstance instanceof Categorie) return;
        foreach ($entityInstance->getProduits() as $produit) {
            $em->remove($produit);
        }
    }
    
}
