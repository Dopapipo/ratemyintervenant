<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            //AssociationField::new('classe'),
            //AssociationField::new('author'),
            //POur classe et author faut trouver un moyen de recup les données de l'user connecté

        ];
    }
}
