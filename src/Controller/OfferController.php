<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Secteur;
use App\Form\OfferSearchType;
use App\Form\OfferType;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sasedev\MpdfBundle\Factory\MpdfFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Dompdf\Dompdf;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Service\QrcodeService ;





use Dompdf\Options;

#[Route('/offer')]
class OfferController extends AbstractController
{
    public function __construct(
        private OffreRepository $offreRepository,
        private EntityManagerInterface $em,
        private readonly Environment $twig,
    )
    {
    }

    #[Route('/', name: 'affOffer')]
    public function affOffer(ManagerRegistry $mg , Request $request, PaginatorInterface $paginator): Response
    {
        $params = $request->query->all();

        if (!array_key_exists('offer_search', $params)) {
            $offersQuery = $mg->getRepository(Offre::class)->findAll();
        } else {
            $formParams = $params['offer_search'];

            $offersQuery = $mg->getRepository(Offre::class)->search($formParams);
        }

        $pagination = $paginator->paginate(
            $offersQuery,
            $request->query->getInt('page', 1), 3
        );

        $f = $this->createForm(OfferSearchType::class);
        $f->handleRequest($request);

        if (array_key_exists('offer_search', $params)) {
            $f->get('typeoffre')->setData(reset($params)['typeoffre']);
            $f->get('secteur')->setData($mg->getRepository(Secteur::class)->findOneBy(['idsecteur' => reset($params)['secteur']]));
            $f->get('searchBar')->setData(reset($params)['searchBar']);
        }

        return $this->render('offer/offer.html.twig', [
            'offers' => $pagination,
            'f' => $f->createView(),
        ]);
    }

       #[Route('/Employee', name: 'affOfferEmpl')]
        public function affOfferEmpl(ManagerRegistry $mg , Request $request, PaginatorInterface $paginator): Response
        {
            $params = $request->query->all();
            if (!array_key_exists('offer_search', $params)) {
                $offersQuery = $mg->getRepository(Offre::class)->findAll();
            } else {
                $formParams = $params['offer_search'];

                $offersQuery = $mg->getRepository(Offre::class)->search($formParams);
            }

            $pagination = $paginator->paginate(
                $offersQuery,
                $request->query->getInt('page', 1),
                3
            );

            $f = $this->createForm(OfferSearchType::class);
            $f->handleRequest($request);

            if (array_key_exists('offer_search', $params)) {
                $f->get('typeoffre')->setData(reset($params)['typeoffre']);
                $f->get('secteur')->setData($mg->getRepository(Secteur::class)->findOneBy(['idsecteur' => reset($params)['secteur']]));
                $f->get('searchBar')->setData(reset($params)['searchBar']);
            }

            return $this->render('offer/offerEmpl.html.twig', [
                'offers' => $pagination,
                'f' => $f->createView(),
            ]);
        }

    #[Route('/add', name: 'addOffer')]
    public function add(ManagerRegistry $mr, Request $request, FlashyNotifier $flashy): Response
    {
        $offer = new Offre();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $mr->getManager();
            $em->persist($offer);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success','Offer added successfully!');
            $flashy->success('Offre ajoutée avec succès !');
            return $this->redirectToRoute('affOffer');
        }

        return $this->render('offer/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/update/{id}', name: 'OfferUpdate')]
    public function update(ManagerRegistry $doctrine,$id,  Request  $request): Response
    {
        {
            $offer = $doctrine
                ->getRepository(Offre::class)
                ->find($id);
            $form = $this->createForm(OfferType::class, $offer);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $em = $doctrine->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('success','Offer updated successfully!');

                return $this->redirectToRoute('affOffer');
            }
            return $this->renderForm(
                "offer/update.html.twig",
                ["form" => $form]);
        }
    }

    #[Route('/details/{id}', name: 'offerDetails')]
    public function details(ManagerRegistry $mg, $id): Response
    {
        $offer = $mg->getRepository(Offre::class)->find($id);

        return $this->render('offer/details.html.twig',
            [
            'offer' => $offer,
            ]);
    }

       #[Route('/detailsEmp/{id}', name: 'offerDetailsEmp')]
       public function detailsEmp(ManagerRegistry $mg, $id , Request  $request): Response
       {
           $offer = $mg->getRepository(Offre::class)->find($id);
           $request->getSession()->getFlashBag()->add('success','Your application has been successfully added!');

           return $this->render('offer/detailsEmp.html.twig',
               [
                   'offer' => $offer,
               ]);
       }

    #[Route('/remove/{id}', name: 'OfferRemove')]
    public function remove($id , Request  $request): Response
    {
        $offer = $this->offreRepository->find($id);

        $offer->setSecteur(null);
        $offer->setProprietaire(null);
        $this->em->remove($offer);
        $this->em->flush();
        $request->getSession()->getFlashBag()->add('success','Offer removed successfully!');

        return new RedirectResponse($this->generateUrl('affOffer'));
    }

    #[Route('/homeOffer', name: 'app_homeOffer')]
       public function index(): Response
       {
           return $this->render('offer/homeOffer.html.twig', [
               'controller_name' => 'HomeController',
           ]);
       }

       #[Route('/pdf/{id}', name: 'Offer.pdf')]
       public function pdf(ManagerRegistry $mg, $id): Response
       {
           // Récupérer l'offre à partir de l'identifiant
           $offer = $mg->getRepository(Offre::class)->find($id);

           // Vérifier si l'offre existe
           if (!$offer) {
               throw $this->createNotFoundException('L\'offre n\'existe pas.');
           }

           //  les options du PDF
           $pdfOptions = new Options();
           // Police par défaut
           $pdfOptions->set('defaultFont', 'Arial');
           $pdfOptions->setIsRemoteEnabled(true);

           //instancie Dompdf
           $dompdf = new Dompdf($pdfOptions);

           $context = stream_context_create([
               'ssl' => [
                   'verify_peer' => FALSE,
                   'verify_peer_name' => FALSE,
                   'allow_self_signed' => TRUE
               ]
           ]);
           $dompdf->setHttpContext($context);

           $date = new \DateTime();
           $heure = $date->format('H:i:s');

           $html = $this->renderView('offer/pdf.html.twig', [
               'offer' => $offer,
               'logo_url' => 'https://example.com/media/lancini.png',
               'heure' => $heure
           ]);

           $dompdf->loadHtml($html);

           $dompdf->setPaper('A4', 'portrait');
           $dompdf->render();

           //  nom de fichier
           $fichier = 'Details';

           //  envoie le PDF au navigateur
           $dompdf->stream($fichier, [
               'Attachment' => true
           ]);

           return new Response();
       }


    #[Route('/generate_qr_code/{idOffre}', name:'qrCode')]
    public function qrCode( QrcodeService $qrcodeService,$idOffre)
    {
        $offer = $this->getDoctrine()->getRepository(Offre::class)->find($idOffre);
        $qrCode = $qrcodeService->qrcode($offer);
        return $this->render('offer/details.html.twig', [
            'offer' => $offer,
            'qrCode' => $qrCode
        ]);
    }
}
