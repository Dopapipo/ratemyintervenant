<?php

namespace App\Controller\Admin;

use App\Entity\Matiere;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
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
            TextField::new('name')->setLabel('Nom'),
            AssociationField::new('intervenants')
                ->setLabel('Intervenants')
                ->setRequired(false)
                ->onlyOnForms()
                ->setFormTypeOptionIfNotSet('by_reference', false),
            ArrayField::new('intervenants')->hideOnForm(),
            //->onlyOnForms(), // Affiche le champ uniquement dans les formulaires
            AssociationField::new('classe')
                ->setLabel('Classe')
                ->setRequired(false)
            ,
            //->onlyOnForms(), // Affiche le champ uniquement dans les formulaires
        ];
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('name')
            ->add('intervenants')
            ->add('classe');
    }

}
