<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Intl\Countries;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('sujet')
            ->add('lieu', ChoiceType::class, [
                'label' => 'Select a country',
                'choices' => array_flip(Countries::getNames()),
            ])
            ->add('horaire')
            ->add('dateevent', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'empty_data' => 'Date de naissance',
                'attr' => [
                    'class' => 'form-control flatpickr-input',
                    'data-toggle' => 'flatpickr',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez remplir tous les champs !']),
                    new NotNull(['message' => 'Veuillez saisir la date .']),
                ],
            ])
            ->add('proprietaire',EntityType::class, ['class'=> User::class,
            'choice_label'=>'Nom',
            'multiple'=>false , 
            'expanded'=>false, ])
            ->add('save' , SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
