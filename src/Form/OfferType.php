<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\Secteur;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , TextType::class ,
                [
            'label' => 'Name',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^[a-zA-Z\s]*$/',
                            'message' => 'The name must only contain letters.'
                        ]),
                        new Length([
                            'min' => 2,
                            'max' => 50,
                            'minMessage' => 'The name must contain at least {{ limit }} characters.',
                            'maxMessage' => 'The name cannot contain more than {{ limit }} characters.'
                        ])
                    ]
        ])
            ->add('typeoffre' , ChoiceType::class, [
                'label' => 'Type of offer',
                'choices' => [
                    'Internship' => 'Internship',
                    'Full-time' => 'Full-time',
                    'Part-time' => 'Part-time',
                    'Freelance' => 'Freelance',
                    'Alternation' => 'Alternation',
                    'CDD' => 'CDD',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('description' , TextType::class,
            [
            'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                ],
                    'constraints' => [
                        new Regex([
                            'pattern' => '/^[a-zA-Z\s]*$/',
                            'message' => 'The name must only contain letters.'
                        ])
                    ]
        ])
            ->add('datedebut', DateType::class, [
                'label' => 'Start date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                ],
                'attr' => [
                    'class' => 'form-control',
                ],

            ])
            ->add('datefin', DateType::class, [
                'label' => 'End date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new GreaterThanOrEqual([
                        'propertyPath' => 'parent.all[datedebut].data',
                        'message' => 'The end date should be after or equal to the start date.'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('competence', TextType::class, [
                'label' => 'Skills',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s,:;]*$/',
                        'message' => 'Le champ ne doit contenir que des lettres.'
                    ])
                ]
            ])
            ->add('secteur', EntityType::class, ['class'=> Secteur::class,
                'attr' => [
                    'class' => 'form-control',
                ],
                    'label' => 'Sector',
                    'choice_label'=>'Nom',
                    'multiple'=>false ,
                    'expanded'=>false, ])

            ->add('proprietaire',EntityType::class, ['class'=> User::class,
                'choice_label'=>'Nom',
                'multiple'=>false ,
                'expanded'=>false, ])
            ->add('Create', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}