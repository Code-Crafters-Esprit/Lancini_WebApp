<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('motdepasse', PasswordType::class)
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Simple User' => 'Simple User',
                    'Candidat' => 'Candidat',
                    'Employeur' => 'Employeur',
                    'Administrateur' => 'Administrateur',
                ]
            ])
            ->add('bio')
            ->add('photoFile', FileType::class, [
                'label' => 'Profile Photo',
                'required' => false,
            ])
            ->add('numtel')
            ->add('isVerified')
            // ->add('roles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
