<?php

namespace App\Form;

use App\Entity\Secteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeoffre' , ChoiceType::class, [
                'label' => 'Type of offer',
                'choices' => [
                    'Choose an option' => 'Choose an option',
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
            ->add('secteur', EntityType::class, ['class'=> Secteur::class,
                'label' => 'Sector',
                'choice_label'=>'Nom',
                'multiple'=>false ,
                'placeholder' => 'Choose an option',
                'expanded'=>false,
                'required' => false,
            ])
            ->add('searchBar', TextType::class, [
                'required' => false,
            ])
            ->add('Search', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
