<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Entity\User;
use App\Form\CvType;
use App\Repository\CvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/cv')]
class CvController extends AbstractController
{


     /**
     * @Route("/showcvsmobile", name="app_cvs_mobile", methods={"GET", "POST"})
     */
    public function ShowCvsMobile (EntityManagerInterface $entityManagerInterface){
        $cvs = $entityManagerInterface->getRepository(Cv::class)
        ->findAll();

        $serialize = new Serializer([new ObjectNormalizer()]);
        $formattd = $serialize->normalize($cvs);
        return new JsonResponse($formattd);
    }
    /**
     * @Route("/deletecvmobile/{id}", name="app_cv_mobile_delete", requirements={"id":"\d+"},  methods={"POST","GET"})
     */
    public function deleteCvMobile(Request $request, Cv $cv, EntityManagerInterface $entityManager, $id): Response
    {
        $cv = $entityManager->getRepository(Cv::class)->find($id);
        if ($cv != null) {
            $entityManager->remove($cv);
            $entityManager->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Suppression avec succès");
            return new JsonResponse($formatted);
        }

    
            
    }

    /**
     * @Route("/editcvmobile/{id}", name="app_cv_edit_mobile", methods={"GET", "POST"})
     */
    public function modifierCvMobile(Request $request, EntityManagerInterface $entityManager) {
      $cv= $entityManager->getRepository(Cv::class)
                ->find($request->get("id"));

        $cv->setEducation($request->get("education"));
        $cv->setEmail($request->get("email"));
        $cv->setAdresse($request->get("adresse"));
        $cv->setLangue($request->get("langue"));
        

        $entityManager->persist($cv);
        $entityManager->flush();

        $serialize = new Serializer([new ObjectNormalizer()]);
        $formatted = $serialize->normalize($cv);
        return new JsonResponse("Moddification avec succées");
    }

    /**
     * @Route("/addcvmobile/{idu}", name="app_cv_new_mobile", methods={"GET", "POST"})
     */
    public function addparismobile(Request $request, EntityManagerInterface $entityManager, $idu,): Response
    {
        $cv = new Cv();
        $cv->setNom($request->query->get("nom"));
        $cv->setPrenom($request->query->get("prenom"));
        $cv->setAdresse($request->query->get("adresse"));
        $cv->setCin($request->query->get("cin"));
        $cv->setSexe($request->query->get("sexe"));
        $cv->setDatenaissance(new \DateTime('@'.strtotime($request->get("dateNaissance")."+ 1 day")));
        $cv->setLangue($request->query->get("langue"));
        $cv->setEducation($request->query->get("education"));
        $cv->setUserid($entityManager->getRepository(User::class)->find($idu));
        $cv->setEmail($request->query->get("email"));
        
            $entityManager->persist($cv);
            $entityManager->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Ajout avec succès");
            return new JsonResponse($formatted);
        
    }
    /**
    * @Route("/printcvmobile/{id}", name="app_cv_pdf_mobile", methods={"GET", "POST"})
    */    public function exportCvPDFMobile($id, CvRepository $repo)
    {
        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf();
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);
        $cv = $repo->find($id);
        // dd($cvs);

        // On génère le html
        $html = $this->renderView(
            'cv/print.html.twig',
            [
                'cv' => $cv
            ]
        );

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'cv'. $cv->getCin() . date('c') .'.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);
    
        return new JsonResponse();
    }



  /*  -----------------------------------------------------------------------------------------------------------------*/
    #[Route('/', name: 'app_cv_index', methods: ['GET'])]
    public function index(CvRepository $cvRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->find(User::class, 1);
        $cvs = $entityManager
            ->getRepository(Cv::class)
            ->findAll();

        foreach ($cvs as $key => $cv) {
            if ($cv->getUserid() != $user) {
                unset($cvs[$key]);
            }
        }
        return $this->render('cv/index.html.twig', [
            'cvs' => $cvs,
        ]);
    }

    #[Route('/new', name: 'app_cv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CvRepository $cvRepository, EntityManagerInterface $entityManager): Response
    {
        $cv = new Cv();
        $user = $entityManager->find(User::class, 1);
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('cv')['photo'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $cv->setPhoto($filename);
            $cv->setUserid($user);
            $cvRepository->save($cv, true);

            return $this->redirectToRoute('app_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cv/new.html.twig', [
            'cv' => $cv,
            'form' => $form,
        ]);
    }

    #[Route('/{idcv}', name: 'app_cv_show', methods: ['GET'])]
    public function show(Cv $cv): Response
    {
        return $this->render('cv/show.html.twig', [
            'cv' => $cv,
        ]);
    }

    #[Route('/{idcv}/edit', name: 'app_cv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cv $cv, CvRepository $cvRepository): Response
    {
        $form = $this->createForm(CvType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvRepository->save($cv, true);

            return $this->redirectToRoute('app_cv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cv/edit.html.twig', [
            'cv' => $cv,
            'form' => $form,
        ]);
    }

    #[Route('/{idcv}', name: 'app_cv_delete', methods: ['POST'])]
    public function delete(Request $request, Cv $cv, CvRepository $cvRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cv->getIdcv(), $request->request->get('_token'))) {
            $cvRepository->remove($cv, true);
        }

        return $this->redirectToRoute('app_cv_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route ('/printcv/{id}', name: 'print_cv')]
    public function exportCvPDF($id, CvRepository $repo)
    {
        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf();
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);
        $cv = $repo->find($id);
        // dd($cvs);

        // On génère le html
        $html = $this->renderView(
            'cv/print.html.twig',
            [
                'cv' => $cv
            ]
        );

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'cv'. $cv->getCin() . date('c') .'.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }
}
