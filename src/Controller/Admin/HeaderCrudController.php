<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre de entête'),
            TextareaField::new('content', 'Contenu de notre entête'),
            TextField::new('btnTitre', 'Titre de notre boutton'),
            TextField::new('btnUrl', 'Url de destination de notre boutton'),
            ImageField::new('image','Image')
           ->setBasePath('upload\image\produit')
           ->setUploadDir('public\upload\image\produit')
           
           ->setSortable(false),
            
        ];
    }
     
}
