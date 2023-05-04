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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\File\File;


#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/get/all', name: 'app_user_get_all')]
    public function getAll(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();
        $json = $serializer->serialize($users, 'json', ['groups' => "users"]);
        return new Response($json);
    }

    #[Route('/get/one/{id}', name: 'app_user_get_one')]
    public function getUserJSON($id, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $user = $entityManager
            ->getRepository(User::class)
            ->find($id);
        $json = $serializer->serialize($user, 'json', ['groups' => "users"]);
        return new Response($json);
    }

    #[Route("update/new", name: "addUserJSON")]
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

    #[Route("update/edit/{id}", name: "updateUserJSON")]
    public function updateStudentJSON(Request $req, $id, NormalizerInterface $Normalizer, EntityManagerInterface $entityManager)
    {

        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setEmail($req->get('email'));
        $user->setMotdepasse($req->get('motdepasse'));
        $user->setNom($req->get('nom'));
        $user->setPrenom($req->get('prenom'));
        $user->setRole($req->get('role'));
        $user->setBio($req->get('bio'));
        $user->setPhotopath($req->get('photopath'));
        $user->setNumtel($req->get('numtel'));

        $entityManager->flush();
        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'users']);
        return new Response("User updated successfully " . json_encode($jsonContent));
    }

    #[Route("delete/{id}", name: "deleteUserJSON")]
    public function deleteStudentJSON(Request $req, $id, NormalizerInterface $Normalizer, EntityManagerInterface $entityManager)
    {

        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $jsonContent = $Normalizer->normalize($user, 'json', ['groups' => 'users']);
        return new Response("User deleted successfully " . json_encode($jsonContent));
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $request->getSession()->set('disable_serialization', true);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('photoFile')->getData();
            if ($file instanceof UploadedFile) {
                $photoFilename = uniqid() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('user_photo_directory'),
                    $photoFilename
                );
                $user->setPhotopath($photoFilename);
                $user->setPhotoFile($file);
            }

            $user->setMotdepasse(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('motdepasse')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{idUser}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{idUser}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photoFile')->getData();
            if ($file instanceof UploadedFile) {
                $photoFilename = uniqid() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('user_photo_directory'),
                    $photoFilename
                );
                $user->setPhotopath($photoFilename);
                $user->setPhotoFile($file);
            }
            $user->setMotdepasse(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('motdepasse')->getData()
                )
            );
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{idUser}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getIdUser(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
