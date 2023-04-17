<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Publication;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('datepub')
            
            ->add('description')
            ->add('cat', ChoiceType::class, [
                'choices' => [
                    'Simple Blog' => 'Simple_blog',
                    'Success Story' => 'Success_story',
                    'Advice' => 'Advice'
                ],
                'placeholder' => 'Choose a category',
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
            'data_class' => Publication::class,
        ]);
    }
}
