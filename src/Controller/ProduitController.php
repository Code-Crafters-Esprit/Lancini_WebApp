<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\Produit1Type;
use App\Repository\MaillistRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Mime\Email;


#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/chart', name: 'app_produitbyvendeur_index', methods: ['GET'])]
    public function productsByVendeur(ProduitRepository $produitRepository)
    {
        $data = $produitRepository->findProductsByVendeur();
        $sellers = $produitRepository->findSellersByProductCount();
        
        // $data should be an array of vendeurs and their respective product data
        // Example: [['John', 20], ['Mary', 10], ['Peter', 15]]
        // $sellers should be an array of vendeurs ordered by their product count
        
        return $this->render('produit/products.html.twig', [
            'data' => $data,
            'sellers' => $sellers,
        ]);
    }
    
   #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository, MailerInterface $mailer): Response
    {
      

        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    } 
    #[Route('/market', name: 'app_market_index', methods: ['GET'])]
    public function list(Request $request, ProduitRepository $produitRepository): Response
    {
        $searchTerm = $request->query->get('search', '');
        $categoryFilters = (array)$request->query->get('category', []);
        $priceFilters = (array)$request->query->get('price', []);
    
        $produits = $produitRepository->findAll();
    
        // Apply search term filter
        if (!empty($searchTerm)) {
            $produits = array_filter($produits, function($produit) use ($searchTerm) {
                $nomProduit = strtolower($produit->getNom());
                $searchTerm = strtolower($searchTerm);
                return strpos($nomProduit, $searchTerm) !== false || strpos($nomProduit, str_replace(' ', '', $searchTerm)) !== false;
            });
        }
        // Apply category filters
        if (!empty($categoryFilters)) {
            $produits = array_filter($produits, function($produit) use ($categoryFilters) {
                return in_array($produit->getCategorie(), $categoryFilters);
            });
        }
    
        // Apply price filters
        if (!empty($priceFilters)) {
            $produits = array_filter($produits, function($produit) use ($priceFilters) {
                $prix = $produit->getPrix();
                if (in_array('price1', $priceFilters) && $prix >= 0 && $prix <= 5) {
                    return true;
                } elseif (in_array('price2', $priceFilters) && $prix > 5 && $prix <= 15) {
                    return true;
                } elseif (in_array('price3', $priceFilters) && $prix > 15) {
                    return true;
                } else {
                    return false;
                }
            });
        }
    
        return $this->render('LanciniMarket/index.html.twig', [
            'produits' => $produits,
        ]);
    }
   #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository,MaillistRepository $MaillistRepository, MailerInterface $mailer): Response
    {
        $produit = new Produit();
        $timezone = $this->getParameter('timezone');

        $produit->setDate(new DateTime('now', new \DateTimeZone($timezone)));
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();

            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir') . '/public/images/products',
                        $fileName
                    );

                    $produit->setImage($fileName);
                } catch (FileException $e) {
                    // Handle exception
                }
            }
            $email = (new Email())
            ->from('lancinimarket@gmail.com')
            ->to('mohamedali.naguez@esprit.tn')
            ->subject('New Product Alert!')
            ->html('<p>Check out our new product!</p>');
        
          $mailer->send($email);

            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{idproduit}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{idproduit}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            /** @var UploadedFile $file */
            $file = $form->get('image')->getData();

            if ($file) {
                $fileName = uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('kernel.project_dir') . '/public/images/products',
                        $fileName
                    );

                    $produit->setImage($fileName);
                } catch (FileException $e) {
                    // Handle exception
                }
            }

            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

#[Route('/{idproduit}', name: 'app_produit_delete', methods: ['POST'])]
public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
{
    if ($this->isCsrfTokenValid('delete'.$produit->getIdproduit(), $request->request->get('_token'))) {
        // Check if the image is null and set it to a default image if it is
        if ($produit->getImage() === null) {
            $produit->setImage('default_image.png');
        }
        $produitRepository->remove($produit, true);
    }

    return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
}


}