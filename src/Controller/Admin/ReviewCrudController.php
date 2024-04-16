<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('content'),
            IntegerField::new('grade')
                ->setFormTypeOptions([
                    'attr' => [
                        'min' => 1,
                        'max' => 5,
                    ],
                ]),
            AssociationField::new('intervenant'),
            AssociationField::new('matiere'),
            TextField::new('authorName',User::class)->setLabel('Nom de l\'auteur')->onlyOnIndex(),

            //AssociationField::new('classe'),
            //AssociationField::new('author'),

        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions->disable(Action::EDIT)->disable(Action::NEW);
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined();
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('intervenant')
            ->add('matiere');
    }
}
