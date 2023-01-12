<?php

namespace App\Form;

use App\Entity\CreatedPerfume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreatedPerfumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('proportionHeadScent')
            ->add('proportionHeartScent')
            ->add('proportionBaseScent')
            ->add('headScent')
            ->add('heartScent')
            ->add('baseScent')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatedPerfume::class,
        ]);
    }
}
