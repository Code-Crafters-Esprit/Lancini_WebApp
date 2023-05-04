<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Form\ApiRegistrationFormType;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class UserApiController extends AbstractController
{
    #[Route('/api/register', name: 'user_api_register', methods: ['POST'])]
    public function apiRegister(Request $request, SerializerInterface $serializer, NormalizerInterface $Normalizer, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, JWTTokenManagerInterface $jwtManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $form = $this->createForm(ApiRegistrationFormType::class, $user, [
            'csrf_protection' => false, // disabling CSRF protection for API requests
        ]);
        // submit the form with the JSON data
        $form->submit($data);

        if ($form->isSubmitted() && !$form->isValid()) {
            // return validation errors as JSON response
            $errors = [];
            foreach ($form->getErrors(true, true) as $error) {
                $errors[] = [
                    'field' => $error->getOrigin()->getName(),
                    'message' => $error->getMessage(),
                ];
            }
            $responseData = [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $errors,
            ];
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $plainPassword = $form->get('motdepasse')->getData();
            $user->setMotdepasse(
                $userPasswordHasher->hashPassword(
                    $user,
                    $plainPassword
                )
            );

            $token = $jwtManager->create($user);

            $entityManager->persist($user);
            $entityManager->flush();
            $responseData = [
                'success' => true,
                'message' => 'User created successfully',
                'user' => $serializer->serialize($user, 'json', ['groups' => "users"]),
                'token' => $token,
            ];
        }

        $jsonContent = $Normalizer->normalize($responseData);
        return new Response(json_encode($jsonContent));
    }
}
