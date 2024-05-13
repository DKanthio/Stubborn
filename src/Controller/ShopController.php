<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cart;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class ShopController extends AbstractController
{
   
    private $entityManager;
  

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
      
    }

   
   

   
    /**
     * @Route("/products", name="products")
     */
    public function index(Request $request): Response
    {
        

        $filteredProducts = $this->filterProductsByPrice($request);

        $companyInfo = [
            'name' => 'Stubborn',
            'address' => 'Piccadilly Circus, London W1J 0DA, Royaume-Uni',
            'contact_email' => 'stubborn@blabla.com',
            'slogan' => "Don't compromise on your look",
        ];
    
        // Obtenez tous les produits depuis la base de données
        $products = $this->entityManager->getRepository(Product::class)->findAll();
    
        // Si aucun produit n'existe en base de données, créez et ajoutez les produits par défaut
        if (empty($products)) {
            $defaultProducts = Product::createProducts();
    
            foreach ($defaultProducts as $product) {
                $this->entityManager->persist($product);
            }
    
            $this->entityManager->flush();
    
            // Récupérez à nouveau les produits après les avoir ajoutés à la base de données
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }
    
        // Passer les produits filtrés à la vue Twig
        return $this->render('product/index.html.twig', [
            'companyInfo' => $companyInfo,
            'featuredProducts' => $filteredProducts ? $filteredProducts : $products,
        ]);

    }
  
    private function filterProductsByPrice(Request $request): array
    {
        
        $price_filter = $request->query->get('price_filter', '');

        if ($price_filter) {
            $price_range = explode('-', $price_filter);
            $min_price = $price_range[0];
            $max_price = $price_range[1];

            // Appel à la fonction à l'intérieur de la classe avec $this->
            $filtered_products = $this->get_products_by_price_range($min_price, $max_price);

            return $filtered_products;
        } else {
            // Retournez un tableau vide s'il n'y a pas de filtre de prix
            return [];
        }
    }

    private function get_products_by_price_range($min_price, $max_price)
    {
        $products = [
            ['id' => 1, 'name' => 'Blackbelt', 'price' => '29.90', 'image' => '1.jpeg'],
            ['id' => 2, 'name' => 'BlueBelt', 'price' => '29.90', 'image' => '2.jpeg'],
            ['id' => 3, 'name' => 'Street', 'price' => '34.50', 'image' => '3.jpeg'],
            ['id' => 4, 'name' => 'Pokeball', 'price' => '45.00', 'image' => '4.jpeg'],
            ['id' => 5, 'name' => 'PinkLady', 'price' => '29.90', 'image' => '5.jpeg'],
            ['id' => 6, 'name' => 'Snow', 'price' => '32.00', 'image' => '6.jpeg'],
            ['id' => 7, 'name' => 'Greyback', 'price' => '28.50', 'image' => '7.jpeg'],
            ['id' => 8, 'name' => 'BlueCloud', 'price' => '45.00', 'image' => '8.jpeg'],
            ['id' => 9, 'name' => 'BornInUsa', 'price' => '59.90', 'image' => '9.jpeg'],
            ['id' => 10, 'name' => 'GreenSchool', 'price' => '42.20', 'image' => '10.jpeg'],
        ];

        $filtered_products = [];

        foreach ($products as $product) {
            if ($product['price'] >= $min_price && $product['price'] <= $max_price) {
                $filtered_products[] = $product;
            }
        }

        return $filtered_products;
    }

    /**
     * @Route("/product/{id}", name="product_details")
     */
    public function showProductDetails(Request $request, $id)
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        $companyInfo = [
            'name' => 'Stubborn',
            'address' => 'Piccadilly Circus, London W1J 0DA, Royaume-Uni',
            'contact_email' => 'stubborn@blabla.com',
            'slogan' => "Don't compromise on your look",
        ];

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        return $this->render('product/details.html.twig', [
            'companyInfo' => $companyInfo,
            'product' => $product,
        ]);
    }
  
    /**
     * @Route("/add-to-cart/{id}", name="add_to_cart")
     */

   public function addToCart(Request $request, ProductRepository $productRepository, $id): Response
    {
        // Récupérer la taille sélectionnée depuis la requête
        $size = $request->query->get('size');

        // Vérifier si la taille est définie
        if ($size !== null) {
        // Récupérer le produit depuis la base de données en utilisant le repository
        $product = $this->entityManager->getRepository(Product::class)->find($id);
        
        // Vérifier si le produit existe
        if (!$product) {
        throw $this->createNotFoundException('Le produit n\'existe pas.');
        }
         
        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        // Vérifier si le stock de la taille sélectionnée est supérieur à zéro
        switch ($size) {
            case 'XS':
                if ($product->getStockXS() <= 0) {
                    // Rediriger avec un message d'erreur si le stock est épuisé
                    $this->addFlash('error', 'Le stock de la taille XS est épuisé.');
                    return $this->redirectToRoute('products');
                }
                break;
            case 'S':
                if ($product->getStockS() <= 0) {
                    // Rediriger avec un message d'erreur si le stock est épuisé
                    $this->addFlash('error', 'Le stock de la taille S est épuisé.');
                    return $this->redirectToRoute('products');
                }
                break;
               
            case 'M':
                if ($product->getStockS() <= 0) {
                    // Rediriger avec un message d'erreur si le stock est épuisé
                    $this->addFlash('error', 'Le stock de la taille S est épuisé.');
                    return $this->redirectToRoute('products');
                }
                break;


            case 'L':
                if ($product->getStockS() <= 0) {
                    // Rediriger avec un message d'erreur si le stock est épuisé
                    $this->addFlash('error', 'Le stock de la taille S est épuisé.');
                    return $this->redirectToRoute('products');
                }
                break;
            case 'XL':
                if ($product->getStockS() <= 0) {
                    $this->addFlash('error', 'Le stock de la taille S est épuisé.');
                    return $this->redirectToRoute('products');
                }
                break;

            default:
                // Gérer le cas où la taille n'est pas valide
                break;
        }
        // Créer une nouvelle instance de Cart
        $cart = new Cart();
        $cart->setProduct($product);
        $cart->setSize($size);
        $cart->addToCart($product, $size);

        // Persister et flush le Cart
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

       


        // Rediriger vers la page panier
        return $this->redirectToRoute('cart');
        } else {
        
        return $this->redirectToRoute('products');
       }

       
    }

    
    public function removeFromCart(Request $request, int $cartId): Response
{
    // Récupérer le panier à partir de son identifiant
    $cart = $this->entityManager->getRepository(Cart::class)->find($cartId);

    // Vérifier si le panier existe
    if (!$cart) {
        throw $this->createNotFoundException('Le panier n\'existe pas.');
    }
    
    // Récupérer le produit associé au panier
    $product = $cart->getProduct();
    
    // Supprimer le panier de la base de données
    $this->entityManager->remove($cart);
    $this->entityManager->flush();

    // Remettre l'article en stock approprié
    $cart->removeFromCart();
    
    // Persister et flush le Product pour sauvegarder les changements
    $this->entityManager->persist($product);
    $this->entityManager->flush();

    // Rediriger l'utilisateur vers la page du panier
    return $this->redirectToRoute('cart');
}

    
}
    


