<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuizAnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $quizzes = $options['data'];

        // dd($quizzes);

        foreach ($quizzes as $quiz) {
            $builder->add('answer_' . $quiz->getId(), ChoiceType::class, [
                'label' => $quiz->getQuestion(),
                'choices' => [
                    $quiz->getReponseCorrecte() => $quiz->getReponseCorrecte(),
                    $quiz->getReponseFausse1() => $quiz->getReponseFausse1(),
                    $quiz->getReponseFausse2() => $quiz->getReponseFausse2(),
                    $quiz->getReponseFausse3() => $quiz->getReponseFausse3(),
                ],
                'expanded' => true,
                'multiple' => false,
                'mapped' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'You have to answer this question'
                    ]),
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
