<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/test')]
class TestAdminController extends AbstractController
{
    #[Route('/sortByAscDiff', name: 'sort_by_asc_diff')]
    public function sortAscDiff(EntityManagerInterface $entityManager, TestRepository $testRepository, Request $request)
    {
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findAll();

        $query = $request->query->get('q');
        $tests = $testRepository->findByNomtest($query);

        $tests = $testRepository->sortByAscDiff();
    
        return $this->render("testAdmin/index.html.twig",[
            'tests' => $tests,
            'query' => $query,
        ]);
    }
    
    #[Route('/sortByDescDiff', name: 'sort_by_desc_diff')]
    public function sortDescDiff(EntityManagerInterface $entityManager, TestRepository $testRepository, Request $request)
    {
        $tests = $entityManager
            ->getRepository(Test::class)
            ->findAll();

        $query = $request->query->get('q');
        $tests = $testRepository->findByNomtest($query);

        $tests = $testRepository->sortByDescDiff();
    
        return $this->render("testAdmin/index.html.twig",[
            'tests' => $tests,
            'query' => $query,
        ]);
    }

    #[Route('/search', name: 'test_search')]
    public function search(EntityManagerInterface $entityManager, Request $request, TestRepository $testRepository): Response
    {
        $tests = $testRepository->findAll();
        $query = $request->query->get('q');
        $tests = $testRepository->findByNomtest($query);

        return $this->render('testAdmin/search.html.twig', [
            'tests' => $tests,
            'query' => $query,
        ]);
    }
    #[Route('/', name: 'admin_test_index', methods: ['GET'])]
    public function index(TestRepository $testRepository, Request $request): Response
    {
        $tests = $testRepository->findAll();
        $query = $request->query->get('q');
        $tests = $testRepository->findByNomtest($query);

        return $this->render('testAdmin/index.html.twig', [
            'tests' => $tests,
            'query' => $query,
        ]);
    }

    #[Route('/new', name: 'admin_test_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TestRepository $testRepository): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testRepository->save($test, true);

            return $this->redirectToRoute('admin_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('testAdmin/new.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_test_show', methods: ['GET'])]
    public function show(Test $test): Response
    {
        return $this->render('testAdmin/show.html.twig', [
            'test' => $test,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_test_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Test $test, TestRepository $testRepository): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $testRepository->save($test, true);

            return $this->redirectToRoute('admin_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('testAdmin/edit.html.twig', [
            'test' => $test,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_test_delete', methods: ['POST'])]
    public function delete(Request $request, Test $test, TestRepository $testRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getId(), $request->request->get('_token'))) {
            $testRepository->remove($test, true);
        }

        return $this->redirectToRoute('admin_test_index', [], Response::HTTP_SEE_OTHER);
    }
}
