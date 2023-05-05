<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\User;
use App\Form\EmailFormType;
use App\Form\PasswordFormType;
use App\Form\ProfileType;
use App\Repository\AbonnementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Image;



class ProfileController extends AbstractController
{
    #[Route('/profile/{idUser}', name: 'app_profile')]
    public function index(UserRepository $userRepository, $idUser, AbonnementRepository $ar): Response
    {
        $user = $userRepository->find($idUser);
        $following = $ar->find3ByUserId($idUser);
        $followersCount = $ar->getNumberOfFollowers($idUser);
        $isFollower = $ar->isFollower($idUser, $this->getUser()->getIduser());
        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'currentUser' => $this->getUser(),
            'following' => $following,
            'followersCount' => $followersCount,
            'isFollower' => $isFollower,
        ]);
    }

    #[Route('/profile/{idUser}/edit', name: 'app_edit_profile')]
    public function edit(UserRepository $userRepository, $idUser, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $userRepository->find($idUser);
        if ($user == $this->getUser()) {
            $form = $this->createForm(ProfileType::class, $user);
            $passwordForm = $this->createForm(PasswordFormType::class);
            $eform = $this->createForm(EmailFormType::class);

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
                }
                $entityManager->persist($user);
                $entityManager->flush();
            }
            $passwordForm->handleRequest($request);
            if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
                if ($userPasswordHasher->isPasswordValid($user, $passwordForm->get('oldPassword')->getData())) {
                    $user->setMotdepasse($userPasswordHasher->hashPassword(
                        $user,
                        $passwordForm->get('newPassword')->getData()
                    ));
                    $entityManager->persist($user);
                    $entityManager->flush();
                } else {
                    $passwordForm->get('oldPassword')->addError(new FormError('Invalid password'));
                }
            }
            $eform->handleRequest($request);
            if ($eform->isSubmitted() && $eform->isValid()) {
                if ($userPasswordHasher->isPasswordValid($user, $eform->get('password')->getData())) {
                    $entityManager->persist($user);
                    $entityManager->flush();
                } else {
                    $eform->get('password')->addError(new FormError('Invalid password'));
                }
            }

            return $this->render('profile/editprofile.html.twig', [
                'user' => $user,
                'currentUser' => $this->getUser(),
                'profileForm' => $form->createView(),
                'emailForm' => $eform->createView(),
                'passwordForm' => $passwordForm->createView(),
            ]);
        }
        return $this->redirectToRoute('app_home');
    }

    #[Route('/follow/{idFollowed}', name: 'app_follow')]
    public function follow(UserRepository $ur, EntityManagerInterface $entityManager, $idFollowed, AbonnementRepository $ar): Response
    {
        $user = $ur->findOneByIdUser($idFollowed);
        if ($this->getUser() && $user) {
            $follower = $this->getUser();
            if ($ar->isFollower($idFollowed, $follower->getIduser())) {
                $ar->removeFollower($idFollowed, $follower->getIduser());
            } else {
                $a = new Abonnement();
                $a->setUserid($follower);
                $a->setUseridfollowed($user);
                $entityManager->persist($a);
                $entityManager->flush();
            }

            return $this->redirect('/profile/' . $idFollowed);
        } else {
            return $this->redirectToRoute('app_home');
        }
    }
}
