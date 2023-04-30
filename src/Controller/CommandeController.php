<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Commande;
use App\Form\Commande1Type;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/commande')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }
    #[Route('/AllCommandes', name: 'commandes', methods: ['GET'])]
    public function getCommandes(CommandeRepository $repo, SerializerInterface $serializer)
    {
        $commandes = $repo->findAll();
       

        $json = $serializer->serialize($commandes, 'json', ['groups' => "commandes"]);

       
        return new Response($json);
    }
   

   #[Route('/chart', name: 'app_chart_index', methods: ['GET'])]
public function salesByVendeur(CommandeRepository $commandeRepository)
{ 
    $data = $commandeRepository->findSalesByVendeur();
    $sellers = $commandeRepository->SalesByVendeurCount();
    // $data should be an array of vendeurs and their respective sales data
    // Example: [['John', 10], ['Mary', 15], ['Peter', 8]]
    
    return $this->render('commande/sales.html.twig', [
        'salesData' => $data,
        'sellers'   => $sellers,
    ]);
}
#[Route("/Commandes/{id}", name: "commande")]
public function StudentId($idCommande, NormalizerInterface $normalizer, CommandeRepository $repo)
{
    $commande = $repo->find($idCommande);
    $commandeNormalises = $normalizer->normalize($commande, 'json', ['groups' => "commandes"]);
    return new Response(json_encode($commandeNormalises));
}
#[Route("addCommandeJSON/new", name: "addCommandeJSON", methods: ['POST'])]
public function addCommandeJSON(Request $req,   NormalizerInterface $Normalizer)
{

    $em = $this->getDoctrine()->getManager();
    $commande = new Commande();
    $commande->setProduit($req->get('produit'));
    $commande->setAcheteur($req->get('acheteur'));
    $commande->setVendeur($req->get('vendeur'));
    $commande->setMontantpaye($req->get('montantpaye'));
    $commande->setDatecommande($req->get('datecommande'));
    $em->persist($commande);
    $em->flush();

    $jsonContent = $Normalizer->normalize($commande, 'json', ['groups' => 'commandes']);
    return new Response(json_encode($jsonContent));
}

#[Route("updateCommandeJSON/{idCommande}", name: "updateCommandeJSON")]
    public function updateCommandeJSON(Request $req, $idCommande, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($idCommande);
        $commande->setProduit($req->get('produit'));
        $commande->setAcheteur($req->get('acheteur'));
        $commande->setVendeur($req->get('vendeur'));
        $commande->setMontantpaye($req->get('montantpaye'));
        $commande->setDatecommande($req->get('datecommande'));

        $em->flush();

        $jsonContent = $Normalizer->normalize($commande, 'json', ['groups' => 'commandes']);
        return new Response("Order updated successfully " . json_encode($jsonContent));
    }
    #[Route("deleteCommandeJSON/{idCommande}", name: "deleteCommandeJSON")]
    public function deleteCommandeJSON(Request $req, $idCommande, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($idCommande);
        $em->remove($commande);
        $em->flush();
        $jsonContent = $Normalizer->normalize($commande, 'json', ['groups' => 'commandes']);
        return new Response("Order deleted successfully " . json_encode($jsonContent));
    }
    #[Route('/new', name: 'app_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeRepository $commandeRepository, ProduitRepository $produitRepository): Response
    {
        $commande = new Commande();
        $timezone = $this->getParameter('timezone');

   
        $commande->setDatecommande(new DateTime('now', new \DateTimeZone($timezone)));
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitId = $form->get('produit')->getData();
        $produit = $produitRepository->find($produitId);
        
        $commande->setVendeur($produit->getVendeur());
        $commande->setMontantpaye($produit->getPrix());
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommande}', name: 'app_commande_show', methods: ['GET'])]
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    #[Route('/{idCommande}/edit', name: 'app_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeRepository->save($commande, true);

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommande}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request, Commande $commande, CommandeRepository $commandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getIdCommande(), $request->request->get('_token'))) {
            $commandeRepository->remove($commande, true);
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }

    
}


