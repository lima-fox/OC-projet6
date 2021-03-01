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
use Symfony\Component\Validator\Constraints\File;

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
            ->add('videos', UrlType::class, [
                'label' => 'Vidéo',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Lien Youtube'
                ],
                'mapped' => false
            ])
            ->add('photos', FileType::class, [
                'label' => 'Photo',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de mettre une photo au format jpeg/png.',
                    ])
                ],
            ])
            ->add('group_id', EntityType::class, [
                'class' => Group::class,
                'choice_label' => 'name',
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Ajouter le trick'
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
