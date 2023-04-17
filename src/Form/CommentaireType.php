<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Commentaire;
use App\Validator\NoInappropriateWords;
use App\Validator\NoInappropriateWordsValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraint;




class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('commentaire', TextType::class, [
            'constraints' => [
                new NoInappropriateWords(),
            ],
        ])  
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
            'data_class' => Commentaire::class,
        ]);
    }
}
