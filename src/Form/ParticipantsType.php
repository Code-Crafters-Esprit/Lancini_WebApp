<?php

namespace App\Form;


use App\Entity\Evenement;
use App\Entity\Participants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ParticipantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('idevent',EntityType::class, ['class'=> Evenement::class,
            'choice_label'=>'titre',
            'multiple'=>false , 
            'expanded'=>false, ])
        ->add('iduser',EntityType::class, ['class'=> User::class,
            'choice_label'=>'Nom',
            'multiple'=>false , 
            'expanded'=>false, ])
            ->add('save' , SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
