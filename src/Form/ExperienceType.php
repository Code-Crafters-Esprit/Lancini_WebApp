<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Intern' => 'intern',
                    'Full-time' => 'full-time',
                    'Part-time' => 'part-time',
                    'Contract' => 'contract',
                    'Freelance' => 'freelance',
                    'Temporary' => 'temporary',
                ],
                'placeholder' => 'Choose an experience type'
            ])
            ->add('lieu')
            ->add('secteur')
            ->add('datedebut')
            ->add('datefin')
            ->add('userId');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
