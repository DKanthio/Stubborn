<?php

namespace App\Controller;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FeaturedProduct;


class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(Request $request): Response
    {
        // Vérifiez si l'utilisateur est connecté et s'il a le rôle administrateur
        if (!$this->getUser() || !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw $this->createAccessDeniedException('Accès refusé. Veuillez vous connecter en tant qu\'administrateur.');
        }

        // Traitement des actions de l'utilisateur
        if ($request->isMethod('POST')) {
          

            // Ajouter un produit
            if ($request->request->has('ajouter')) {
                $name = $request->request->get('name');
                $price = $request->request->get('price');
                $image = $request->request->get('image');
                $StockXS = $request->request->get('StockXS');
                $StockS = $request->request->get('StockS');
                $StockM = $request->request->get('StockM');
                $StockL = $request->request->get('StockL');
                $StockXL = $request->request->get('StockXL');

                // Créez une nouvelle instance de Product
                $product = new Product();
                $product->setName($name);
                $product->setPrice($price);
                $product->setImage($image);
                $product->setStockXS($StockXS);
                $product->setStockS($StockS);
                $product->setStockM($StockM);
                $product->setStockL($StockL);
                $product->setStockXL($StockXL);

                // Persistez le nouveau produit
                $this->entityManager->persist($product);

                // Enregistrez les modifications dans la base de données
                $this->entityManager->flush();

                // Redirigez l'utilisateur vers la même page pour éviter la soumission multiple
                return $this->redirectToRoute('admin_dashboard');
            }
            // Modifier un produit
            elseif ($request->request->has('modifier')) {
            // Récupérer le produit à partir de la base de données
            $productId = $request->request->get('productId');
            $product = $this->entityManager->getRepository(Product::class)->find($productId); 

            // Vérifier si le produit existe
            if ($product) {
            // Modifier les propriétés du produit
            $product->setName($request->request->get('name'));
            $product->setPrice($request->request->get('price'));
            $product->setImage($request->request->get('image'));
           
            if ($request->request->has('isFeatured') && $request->request->get('isFeatured') === 'true') {
                // Si oui, créez une instance de FeaturedProduct et liez-la au produit
                $featuredProduct = new FeaturedProduct();
                $featuredProduct->setProductId($product->getId());
                $featuredProduct->setName($product->getName());
                $featuredProduct->setPrice($product->getPrice());
                $featuredProduct->setImage($product->getImage());
                $this->entityManager->persist($featuredProduct);
            }

            // Enregistrer les modifications dans la base de données
            $this->entityManager->flush();
            }
            }

        
            // Supprimer un produit
            elseif ($request->request->has('supprimer')) {
                $productId = $request->request->get('productId');
                $product = $this->entityManager->getRepository(Product::class)->find($productId);

                if ($product) {
                    // Supprimez le produit de la base de données
                    $this->entityManager->remove($product);
                    $this->entityManager->flush();
                }

                // Redirigez l'utilisateur vers la même page pour éviter la soumission multiple
                return $this->redirectToRoute('admin_dashboard');
            }
        }

        // Récupérez tous les produits depuis la base de données pour les afficher dans la vue
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $companyInfo = [
            'name' => 'Stubborn',
            'address' => 'Piccadilly Circus, London W1J 0DA, Royaume-Uni',
            'contact_email' => 'stubborn@blabla.com',
            'slogan' => "Don't compromise on your look",
        ];
    
         
        // Rendez la vue et passez les produits à afficher
        return $this->render('admin/index.html.twig', [
            'products' => $products,
            'companyInfo' => $companyInfo,
        ]);
    }
}
