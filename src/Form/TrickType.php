<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use App\Entity\Video;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\File;;

use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Validator\Constraints\Url;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du trick',
                'constraints' => new Length(['min' => 3]),
                'attr' => [
                    'placeholder' => 'Ajouter un titre'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'constraints' => new Length(['min' => 10]),
                'attr' => [
                    'placeholder' => 'Ajouter une description'
                ]
            ])
            ->add('group_id', EntityType::class, [
                'class' => Group::class,
                'label' => 'Groupe',
                'choice_label' => 'label',
                'expanded' => false,
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Confirmer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
