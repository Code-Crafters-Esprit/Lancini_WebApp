<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Form\CvType;
use App\Repository\CvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cv')]
class CvAdminController extends AbstractController
{
    #[Route('/', name: 'admin_cv_index', methods: ['GET'])]
    public function index(CvRepository $cvRepository): Response
    {
        return $this->render('cvAdmin/index.html.twig', [
            'cvs' => $cvRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_cv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CvRepository $cvRepository): Response
    {
        $cv = new Cv();
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvRepository->save($cv, true);

            return $this->redirectToRoute('admin_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cvAdmin/new.html.twig', [
            'cv' => $cv,
            'form' => $form,
        ]);
    }

    #[Route('/{idcv}', name: 'admin_cv_show', methods: ['GET'])]
    public function show(Cv $cv): Response
    {
        return $this->render('cvAdmin/show.html.twig', [
            'cv' => $cv,
        ]);
    }

    #[Route('/{idcv}/edit', name: 'admin_cv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cv $cv, CvRepository $cvRepository): Response
    {
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvRepository->save($cv, true);

            return $this->redirectToRoute('admin_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cvAdmin/edit.html.twig', [
            'cv' => $cv,
            'form' => $form,
        ]);
    }

    #[Route('/{idcv}', name: 'admin_cv_delete', methods: ['POST'])]
    public function delete(Request $request, Cv $cv, CvRepository $cvRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cv->getIdcv(), $request->request->get('_token'))) {
            $cvRepository->remove($cv, true);
        }

        return $this->redirectToRoute('admin_cv_index', [], Response::HTTP_SEE_OTHER);
    }
}
