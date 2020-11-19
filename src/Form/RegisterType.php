<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre prénom et nom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom et votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre mot de passe',
                'attr' => [
                    'placeholder' => 'Merci de saisir un mot de passe'
                ]
            ])
            ->add('password2', PasswordType::class, [
                'label' => 'Confirmez votre mot de passe',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Merci de confirmer votre mot de passe'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'S\'inscrire'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
