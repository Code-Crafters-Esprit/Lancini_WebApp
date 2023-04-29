<?php

namespace App\Form;

use App\Entity\Test;
use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomtest')
            ->add('difficulte')
            ->add('quizzes'
            // , EntityType::class, [
            //     'class' => Quiz::class,
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('q')
            //             ->orderBy('q.question', 'ASC');
            //     },
            //     'expanded' => true,
            //     'multiple' => true,
            //     'by_reference' => false,
            // ]
        );
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
