<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/{idUser}', name: 'app_profile')]
    public function index(UserRepository $userRepository, $idUser): Response
    {
        $user = $userRepository->find($idUser);
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
