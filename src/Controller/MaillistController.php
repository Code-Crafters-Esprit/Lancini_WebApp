<?php

namespace App\Controller;

use App\Entity\Maillist;
use App\Form\MaillistType;
use App\Repository\MaillistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/maillist')]
class MaillistController extends AbstractController
{
    #[Route('/', name: 'app_maillist_index', methods: ['GET'])]
    public function index(MaillistRepository $maillistRepository): Response
    {
        return $this->render('maillist/index.html.twig', [
            'maillists' => $maillistRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_maillist_new', methods: ['POST'])]
    public function new(Request $request, MaillistRepository $maillistRepository): JsonResponse
    {
        $maillist = new Maillist();
        $form = $this->createForm(MaillistType::class, $maillist);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $maillistRepository->save($maillist, true);
    
            return new JsonResponse(['success' => true]);
        }
    
        return new JsonResponse(['success' => false]);
    }

    #[Route('/{id}', name: 'app_maillist_show', methods: ['GET'])]
    public function show(Maillist $maillist): Response
    {
        return $this->render('maillist/show.html.twig', [
            'maillist' => $maillist,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_maillist_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maillist $maillist, MaillistRepository $maillistRepository): Response
    {
        $form = $this->createForm(MaillistType::class, $maillist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maillistRepository->save($maillist, true);

            return $this->redirectToRoute('app_maillist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('maillist/edit.html.twig', [
            'maillist' => $maillist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maillist_delete', methods: ['POST'])]
    public function delete(Request $request, Maillist $maillist, MaillistRepository $maillistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maillist->getId(), $request->request->get('_token'))) {
            $maillistRepository->remove($maillist, true);
        }

        return $this->redirectToRoute('app_maillist_index', [], Response::HTTP_SEE_OTHER);
    }
}
