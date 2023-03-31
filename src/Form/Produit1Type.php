<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;


class Produit1Type extends AbstractType
{ 
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie')
            ->add('nom', null, [
                'attr' => [
                    'maxlength' => 30,
                ],
                'constraints' => [
                    new Length([
                        'max' => 30,
                        'maxMessage' => 'The product name cannot be longer than {{ limit }} characters',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]*$/',
                        'message' => 'The product name can only contain letters',
                    ]),
                ],
            ])
            ->add('description', null, [
                'attr' => [
                    'maxlength' => 100,
                ],
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'The product description cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('image')
            ->add('prix', null,
             ['attr' => [
                'maxlength' => 4,
            ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{1,4}$/',
                        'message' => 'The price can only contain numbers up to 4 digits',
                    ]),
                ],
            ])
            ->add('date', null, [
                'data' => new DateTime(),
            ])
            ->add('vendeur');
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
