<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('username')
            ->setLabel("Nom d'utilisateur"),
            EmailField::new('email'),
            ArrayField::new('roles'),
            TextField::new('firstName')
            ->setLabel("Prénom"),
            TextField::new('lastName')
            ->setLabel("Nom"),
            BooleanField::new('isVerified')
            ->setLabel("Est vérifié")
            ->hideOnForm()
            ->renderAsSwitch(false),
            BooleanField::new('isBanned')
            ->setLabel("Est banni")
            ->hideOnForm()
            ->renderAsSwitch(false),

        ];
    }
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('username')
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('isVerified')
            ->add('isBanned');
    }

}
