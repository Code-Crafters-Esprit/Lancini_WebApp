<?php

namespace App\Form;

use App\Entity\Secteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\InputType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,
        [
            'label' => 'Name',
            'constraints' => [
                new Assert\Regex([
                    'pattern' => '/^[A-Za-z]*$/',
                    'message' => 'The name must only contain letters.'
                ]),
            ],
            'attr' => [
                'class' => 'form-control',
            ],

        ])
            ->add('description',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('datecreation' , DateType::class, [
                'label' => 'Creation date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('datemodification' , DateType::class, [
                'label' => 'Modification date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('Create', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Secteur::class,
        ]);
    }
}