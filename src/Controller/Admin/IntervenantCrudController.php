<?php
namespace App\Controller\Admin;

use App\Entity\Intervenant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IntervenantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Intervenant::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('name'),
            AssociationField::new('classesTaught')
                ->setLabel('Classes taught')
                ->setRequired(false),
                //->onlyOnForms(), // Affiche le champ uniquement dans les formulaires
            AssociationField::new('matieresEnseignees')
                ->setLabel('Matieres enseignees'),
                //->setRequired(false),
                //->onlyOnForms(), // Affiche le champ uniquement dans les formulaires
            ImageField::new('profilePictureFileName', 'Profile picture')
                ->setBasePath('uploads/images/')
                ->setUploadDir('public/uploads/images')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),


        ];

    }
}

