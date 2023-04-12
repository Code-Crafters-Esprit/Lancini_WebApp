<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TestRepository;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(TestRepository $testRepository): Response
    {
        $tests = $testRepository->findAll();
        shuffle($tests);
        $randomTests = array_slice($tests, 0, 3);
        return $this->render('home/index.html.twig', [
            'tests' => $testRepository->findAll(),
            'randomTests' => $randomTests,
            'controller_name' => 'HomeController',
        ]);
    }
}
