<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Endroid\QrCode\QrCode   ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Endroid\QrCode\Writer\DataUriWriter;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);
            
            

            return $this->redirectToRoute('app_reclamation_index', ['reclamations' => $reclamationRepository->findAll()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $data = $this->generateUrl('app_reclamation_index', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $qrCode = $writer->writeString($data);
        $dataUri = 'data:image/png;base64,' . base64_encode($qrCode);
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
            'qr_code' => $dataUri,

        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    public function generateQrCode()
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $data = $this->generateUrl('app_reclamation_show', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $qrCode = $writer->writeString($data);
        $dataUri = 'data:image/png;base64,' . base64_encode($qrCode);
    
        return $this->render('reclamation/show.html.twig', [
            'qr_code' => $dataUri,
        ]);
    }
}
