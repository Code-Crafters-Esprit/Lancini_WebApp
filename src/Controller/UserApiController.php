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
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;


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

    #[Route('/api/user/get/all', name: 'app_user_get_all')]
    public function getAll(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();
        $json = $serializer->serialize($users, 'json', ['groups' => "users"]);
        return new Response($json);
    }

    #[Route('/api/user/get/one/{id}', name: 'app_user_get_one')]
    public function getUserJSON($id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $user = $entityManager
            ->getRepository(User::class)
            ->find($id);
        $json = $serializer->serialize($user, 'json', ['groups' => "users"]);
        return new Response($json);
    }

    #[Route("/api/user/update/new", name: "addUserJSON")]
    public function addStudentJSON(Request $req, NormalizerInterface $Normalizer, EntityManagerInterface $entityManager)
    {

        $user = new User();
        $user->setEmail($req->get('email'));
        $user->setMotdepasse($req->get('motdepasse'));
        $user->setNom($req->get('nom'));
        $user->setPrenom($req->get('prenom'));
        $user->setRole($req->get('role'));
        $user->setBio($req->get('bio'));
        $user->setPhotopath($req->get('photopath'));
        $user->setNumtel($req->get('numtel'));
        $entityManager->persist($user);
        $entityManager->flush();

        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'users']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/api/user/update/edit/{id}", name: "updateUserJSON", methods: ['GET', 'POST'])]
    public function updateStudentJSON(Request $req, $id, NormalizerInterface $Normalizer, EntityManagerInterface $entityManager)
    {

        $user = $entityManager->getRepository(User::class)->find($id);
        $content = json_decode($req->getContent(), true);
        

        if (isset($content['email'])) {
            $user->setEmail($content['email']);
        }

        if (isset($content['motdepasse'])) {
            $user->setMotdepasse($content['motdepasse']);
        }

        if (isset($content['nom'])) {
            $user->setNom($content['nom']);
        }

        if (isset($content['prenom'])) {
            $user->setPrenom($content['prenom']);
        }

        if (isset($content['role'])) {
            $user->setRole($content['role']);
        }

        if (isset($content['bio'])) {
            $user->setBio($content['bio']);
        }

        if (isset($content['photopath'])) {
            $user->setPhotopath($content['photopath']);
        }

        if (isset($content['numtel'])) {
            $user->setNumtel($content['numtel']);
        }

        $entityManager->flush();
        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'users']);

        return new Response(json_encode($jsonContent));
    }

    #[Route("/api/user/delete/{id}", name: "deleteUserJSON")]
    public function deleteStudentJSON(Request $req, $id, NormalizerInterface $Normalizer, EntityManagerInterface $entityManager)
    {

        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'users']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/api/user/info/{token}", name: "userTokenJSON", methods: ['GET', 'POST'])]
    public function getUserInfo(UserRepository $ur, Request $request, JWTTokenManagerInterface $jwtManager, NormalizerInterface $Normalizer, $token, JWTEncoderInterface $jwtEncoder)
    {

        $tokenPayload = $jwtEncoder->decode($token);
        $username = $tokenPayload['username'];
        $user = $ur->findOneByEmail($username);
        $photoname = $user->getPhotopath();
        $userPhotoPath = $this->getParameter('kernel.project_dir') . '/public/uploads/user_photos/' . $photoname;
        if (is_file($userPhotoPath) && file_exists($userPhotoPath)) {
            $photoContent = base64_encode(file_get_contents($userPhotoPath));
            $user->setPhotopath($photoContent);
        }
        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'users']);
        return new Response(json_encode($jsonContent));
    }

    #[Route("/users/{id}/photo", name: "user_photo", methods: ['GET', 'POST'])]
    public function getUserPhoto($id, UserRepository $ur)
    {
        // Retrieve the user's photo file name from your database or storage
        $photoname = $ur->find($id)->getPhotopath();
        $userPhotoPath = $this->getParameter('kernel.project_dir') . '/public/uploads/user_photos/' . $photoname;
        // Return the photo as a Symfony Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->setContent(file_get_contents($userPhotoPath));

        return $response;
    }
}
