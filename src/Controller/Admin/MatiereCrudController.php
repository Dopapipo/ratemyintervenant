<?php

namespace App\Controller\Admin;

use App\Entity\Matiere;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MatiereCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Matiere::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('intervenants')
                ->setLabel('Intervenants')
                ->setRequired(false),
            //->onlyOnForms(), // Affiche le champ uniquement dans les formulaires
            AssociationField::new('classe')
                ->setLabel('Classe')
                ->setRequired(false),
            //->onlyOnForms(), // Affiche le champ uniquement dans les formulaires
        ];
    }

}
