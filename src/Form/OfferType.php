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




class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom' , TextType::class ,
                [
            'label' => 'Name',
        ])
            ->add('typeoffre' , TextType::class,
                [
                    'label' => 'type of offer',
                ])
            ->add('description' , TextType::class,
            [
            'label' => 'Description',
        ])
            ->add('datedebut' , DateType::class,
                [
                    'label' => 'Start date',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ])
            ->add('datefin', DateType::class,
                [
                    'label' => 'End date',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ])
            ->add('competence' , TextType::class,
                [
                    'label' => 'skills',
                ])
            ->add('secteur', EntityType::class, ['class'=> Secteur::class,

                    'label' => 'Sector',
                    'choice_label'=>'Nom',
                    'multiple'=>false ,
                    'expanded'=>false, ])

            ->add('proprietaire',EntityType::class, ['class'=> User::class,
                'choice_label'=>'Nom',
                'multiple'=>false ,
                'expanded'=>false, ])
            ->add('Create', SubmitType::class);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
