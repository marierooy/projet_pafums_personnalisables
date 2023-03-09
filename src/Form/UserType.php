<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse e-mail',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe',
            ])
            ->add('lastName', null, [
                'label' => 'Votre nom',
            ])
            ->add('firstName', null, [
                'label' => 'Votre prénom',
            ])
            ->add('address', null, [
                'label' => 'Votre adresse',
            ])
            ->add('city', null, [
                'label' => 'Votre Ville',
            ])
            ->add('zipCode', null, [
                'label' => 'Votre code postal',
            ])
            ->add('country', null, [
                'label' => 'Votre pays',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
