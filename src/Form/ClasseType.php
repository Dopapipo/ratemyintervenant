<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Intervenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('intervenants', EntityType::class, [
                'class' => Intervenant::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'mapped' => false, //Pour ne pas afficher car pas nécessaire
                'label' => false, // Cacher le label du champ
                'attr' => [
                    'style' => 'display: none;', // Cacher le champ avec du CSS
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
