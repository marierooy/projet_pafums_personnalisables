<?php

namespace App\Form;

use App\Form\ProductType;
use App\Entity\CreatedPerfume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CreatedPerfumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('proportionHeadScent', IntegerType::class,
            [
                'attr' => [
                  'min' => 0,
                  'max' => 100,
                  'int' => true,
                ]
            ])
            ->add('proportionHeartScent', IntegerType::class,
            [
                'attr' => [
                  'min' => 0,
                  'max' => 100,
                  'int' => true,
                ]
            ])
            ->add('proportionBaseScent', IntegerType::class,
            [
                'attr' => [
                  'min' => 0,
                  'max' => 100,
                  'int' => true,
                ]
            ])
            ->add('headScent')
            ->add('heartScent')
            ->add('baseScent')
            ->add('products', null, [
                'attr' => ['class' => 'select2-multiple']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreatedPerfume::class,
        ]);
    }
}
