<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Maillist;
use App\Form\Produit1Type;
use App\Repository\MaillistRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Filesystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Twig\Environment;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Mime\Email;
use App\Form\MaillistType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


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
    #[Route("/AllProduits", name: "list")]
    //* Dans cette fonction, nous utilisons les services NormlizeInterface et StudentRepository, 
    //* avec la méthode d'injection de dépendances.
    public function getProduits(ProduitRepository $repo, SerializerInterface $serializer)
    {
        $produits = $repo->findAll();
        //* Nous utilisons la fonction normalize qui transforme le tableau d'objets 
        //* students en  tableau associatif simple.
        // $studentsNormalises = $normalizer->normalize($students, 'json', ['groups' => "students"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        // $json = json_encode($studentsNormalises);

        $json = $serializer->serialize($produits, 'json', ['groups' => "produits"]);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }
    #[Route("/Produits/{id}", name: "produits")]
    public function StudentId($id, NormalizerInterface $normalizer, ProduitRepository $repo)
    {
        $produit = $repo->find($id);
        $produitNormalises = $normalizer->normalize($produit, 'json', ['groups' => "produits"]);
        return new Response(json_encode($produitNormalises));
    }
    #[Route("addProduitJSON/new", name: "addProduitJSON")]
    public function addStudentJSON(Request $req,   NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();
        $produit->setNom($req->get('nom'));
        $produit->setCategorie($req->get('categorie'));
        $produit->setDescription($req->get('description'));
        $produit->setDate($req->get('date'));
        $produit->setPrix($req->get('prix'));
        $produit->setImage($req->get('image'));

        $em->persist($produit);
        $em->flush();

        $jsonContent = $Normalizer->normalize($produit, 'json', ['groups' => 'produits']);
        return new Response(json_encode($jsonContent));
    }
    #[Route("updateProduitJSON/{idproduit}", name: "updateProduitJSON")]
    public function updateStudentJSON(Request $req, $idproduit, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($idproduit);
        $produit->setNom($req->get('nom'));
        $produit->setCategorie($req->get('categorie'));
        $produit->setDescription($req->get('description'));
        $produit->setDate($req->get('date'));
        $produit->setPrix($req->get('prix'));
        $produit->setImage($req->get('image'));

        $em->flush();

        $jsonContent = $Normalizer->normalize($produit, 'json', ['groups' => 'produits']);
        return new Response("Produit updated successfully " . json_encode($jsonContent));
    }
    #[Route("deleteProduitJSON/{idproduit}", name: "deleteProduitJSON")]
    public function deleteStudentJSON(Request $req, $idproduit, NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($idproduit);
        $em->remove($produit);
        $em->flush();
        $jsonContent = $Normalizer->normalize($produit, 'json', ['groups' => 'produits']);
        return new Response("Product deleted successfully " . json_encode($jsonContent));
    }
   #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository){
      

        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    } 
    #[Route('/market', name: 'app_market_index', methods: ['GET'])]
    public function list(Request $request, ProduitRepository $produitRepository, PaginatorInterface $paginator, MaillistRepository $maillistRepository): Response
    {
        $searchTerm = $request->query->get('search', '');
        $categoryFilters = (array) $request->query->get('category', []);
        $priceFilters = (array) $request->query->get('price', []);
    
        $produits = $produitRepository->findByFilters($searchTerm, $categoryFilters, $priceFilters);
    
        $produits = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            9 // limit of 10 items per page
        );
    
        $maillist = new Maillist();
        $form = $this->createForm(MaillistType::class, $maillist);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $maillistRepository->save($maillist, true);
    
            return new JsonResponse(['success' => true]);
        }
    
        return $this->render('LanciniMarket/index.html.twig', [
            'produits' => $produits,
            'maillist' => $maillist,
            'form' => $form->createView(),
            'search' => $searchTerm,
        ]);
    }
     #[Route('/market/search', name: 'app_market_search', methods: ['GET'])]
public function search(Request $request, ProduitRepository $produitRepository): JsonResponse
{
    $searchTerm = $request->query->get('search', '');
    $categoryFilters = (array) $request->query->get('category', []);
    $priceFilters = (array) $request->query->get('price', []);

    $produitsQuery = $produitRepository->createQueryBuilder('p');

    // Apply search term filter
    if (!empty($searchTerm)) {
        $produitsQuery->andWhere('LOWER(p.nom) LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . strtolower($searchTerm) . '%');
    }

    // Apply category filters
    if (!empty($categoryFilters)) {
        $produitsQuery->andWhere('p.categorie IN (:categories)')
            ->setParameter('categories', $categoryFilters);
    }

    // Apply price filters
    if (!empty($priceFilters)) {
        $priceFilterQuery = $produitsQuery->expr()->orX();
        foreach ($priceFilters as $filter) {
            if ($filter === 'price1') {
                $priceFilterQuery->add($produitsQuery->expr()->between('p.prix', 0, 5));
            } elseif ($filter === 'price2') {
                $priceFilterQuery->add($produitsQuery->expr()->between('p.prix', 5, 15));
            } elseif ($filter === 'price3') {
                $priceFilterQuery->add($produitsQuery->expr()->gt('p.prix', 15));
            }
        }
        $produitsQuery->andWhere($priceFilterQuery);
    }

    $produits = $produitsQuery->getQuery()->getResult();

    $data = [];
    foreach ($produits as $produit) {
        $data[] = [
            'nom' => $produit->getNom(),
            'prix' => $produit->getPrix(),
            'description' => $produit->getDescription(),
            'categorie' => $produit->getCategorie(),
        ];
    }

    return $this->json($data);
}
    
   #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
   public function new(Request $request, ProduitRepository $produitRepository, MaillistRepository $MaillistRepository, MailerInterface $mailer, EntityManagerInterface $entityManager, Environment $twig): Response
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
           $emailList = $entityManager->getRepository(MailList::class)->findAll();
           $emailList = array_map(function($mailList) {
               return $mailList->getEmail();
           }, $emailList);
           foreach ($emailList as $email) {
            $html = $twig->render('LanciniMarket/mail.html.twig', [             
                'produit' => $produit, ]);
               $email = (new Email())
                       ->from('lancinimarket@gmail.com')
                       ->to($email)
                       ->subject('New Product Alert!')
                       ->html($html);
                   
               $mailer->send($email);
           }
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
    #[Route('/buy/{idproduit}', name: 'app_produit_buy', methods: ['GET'])]
    public function buy(Produit $produit): Response
    {$entityManager = $this->getDoctrine()->getManager();

        $commande = new Commande();
        $commande->setProduit($produit);
        $commande->setMontantpaye($produit->getPrix());
        $commande->setDatecommande(new DateTime());
        $commande->setVendeur($produit->getVendeur());
        $commande->setAcheteur($produit->getVendeur());
    
        // Persist the Commande object to the database
        $entityManager->persist($commande);
        $entityManager->flush();
        return $this->render('produit/buy.html.twig', [
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
    $filesystem= new Filesystem();
    try {
        $imagePath = $this->getParameter('kernel.project_dir') . '/public/images/products'.'/'.$produit->getImage();
        if ($produit->getImage() !== null && $filesystem->exists($imagePath)) {
            $filesystem->remove($imagePath);
        }
        if ($this->isCsrfTokenValid('delete'.$produit->getIdproduit(), $request->request->get('_token'))) {
            // Check if the image is null and set it to a default image if it is
            if ($produit->getImage() === null) {
                $produit->setImage('default_image.png');
            }
            $produitRepository->remove($produit, true);
        }
    } catch (\Exception $e) {
        // handle the exception, for example:
        $this->addFlash('error', 'An error occurred while deleting the item.');
        return $this->redirectToRoute('app_produit_index');
    }

    return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
}

}