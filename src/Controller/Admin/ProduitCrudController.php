<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class ProduitCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE='duplicate';
    public const PRODUIT_BASE_PATH='upload\image\produit';
    public const PRODUIT_UPLOAD_DIR='public\upload\image\produit';

    

    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    public function configureActions(Actions $actions ): Actions
    {
        $duplicate=Action::new(self::ACTION_DUPLICATE)
           ->linkToCrudAction('duplicateProduit');
        return $actions
           ->add(Crud::PAGE_EDIT,$duplicate)
           ->reorder(Crud::PAGE_EDIT,[self::ACTION_DUPLICATE, Action::SAVE_AND_RETURN]);
           
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom','Nom ')->setRequired(false),
            NumberField::new('qtestock','Quantité Stock '),
            NumberField::new('tauxtva','TVA'),
            NumberField::new('tauxremise','Remise'),
            TextField::new('alert_stock','Alert Stock'),

            TextEditorField::new('proddescr','Description'),
            MoneyField::new('prix')->setCurrency('TND'),
           DateTimeField::new('updatedAt','Mis a jour le:'),
           DateTimeField::new('createdAt','Crée le :'),
           BooleanField::new('TopVente','Plus vendu'),
           AssociationField::new('categorie'),
           ImageField::new('image','Image')
           ->setBasePath('upload\image\produit')
           ->setUploadDir('public\upload\image\produit')
           
           ->setSortable(false),
            

        ];
    }
    public function persistEntity(EntityManagerInterface  $em , $entityInstance): void
    {
        if(!$entityInstance instanceof Produit) return;

        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        
        parent::persistEntity($em,$entityInstance);

    }
    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Produit) return;

        $entityInstance->setupdatedAt(new \DateTimeImmutable);
        
        parent::updateEntity($em,$entityInstance);
    }
    public function duplicateProduit(AdminContext $context,AdminUrlGenerator $adminUrlGenerator, EntityManagerInterface $em) : Response
    {
        /** @var produit $produit */
      $produit=$context->getEntity()->getInstance();
      $duplicateProduit = clone $produit;
      parent::persistEntity($em,$duplicateProduit);
      $url = $adminUrlGenerator->setController(self::class)
       ->setAction(Action::DETAIL)
       ->setEntityId($duplicateProduit->getId())
       ->generateUrl();
      
      return $this->redirect($url);
    }
}
