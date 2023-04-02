<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LoginFormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends AbstractController
{
    #[Route('/login', name: 'app_user')]
    public function index(): Response
    {
        $form = $this->createFormBuilder()
        ->add('Email', EmailType::class)
        ->add('Password', PasswordType::class)
        ->add('save', SubmitType::class, ['label' => 'Login'])
        ->getForm();

        return $this->render('user/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
