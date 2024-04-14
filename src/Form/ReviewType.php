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
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   $intervenant = $options['var'];
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
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'name',
                'required' => true,
                'label' => 'Matière',
                'query_builder' => function (MatiereRepository $matiereRepository) use ($intervenant) {
                    return $matiereRepository->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC')
                        ->where('m.classe = :classe AND :intervenant MEMBER OF m.intervenants')
                        ->setParameter('classe', $this->security->getUser()->getClasse())
                        ->setParameter('intervenant', $intervenant );
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
            'var'=>null,
        ]);
    }
}
