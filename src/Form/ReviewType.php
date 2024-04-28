<?php

namespace App\Form;

use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Entity\Review;
use App\Entity\User;
use App\Repository\MatiereRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   $intervenant = $options['intervenant'];
        $user = $options['user'];
        $mode = $options['mode'];
        $builder
            ->add('content', TextareaType::class, [
                'required'=>false,
                'label' => 'Message',
                'attr' => [
                    'placeholder' => '2000 caractères maximum',
                    'maxlength'=>2000,



                ],
            ])
            ->add('grade', RangeType::class, [
                'label' => 'Note',
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                ],
            ])

        ;
        //Only show matiere field if the form is in new mode
        if ($mode === 'new') {
            $builder->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'name',
                'required' => true,
                'label' => 'Matière',
                'query_builder' => function (MatiereRepository $matiereRepository) use ($user, $intervenant) {
                    return $matiereRepository->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC')
                        ->where('m.classe = :classe AND :intervenant MEMBER OF m.intervenants')
                        ->setParameter('classe', $user->getClasse())
                        ->setParameter('intervenant', $intervenant );
                },
            ]);
        }
        if ($mode === 'edit') {
            //No need for extra logic for now
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
            'intervenant'=>null,
            'user'=>null,
            'mode'=>null
        ]);
    }
}
