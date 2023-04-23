<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Blackknight467\StarRatingBundle\Form\RatingType;
use Blackknight467\StarRatingBundle\Blackknight467StarRatingBundle;



class Avis1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('note', RatingType::class, [
                'label' => 'Note',
                'stars' => 5,
                'expanded' => true,
                'required' => true,
            ])
                
            ->add('date')
            ->add('idProduit')
            ->add('idevaluateuruser')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
