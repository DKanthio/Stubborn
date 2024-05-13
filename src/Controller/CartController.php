<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }
    
    /**
    * @Route("/cart", name="cart")
    */
    public function cart(Request $request): Response
    {
    // Récupérer les produits du panier depuis la session
    $cart = $this->entityManager->getRepository(Cart::class)->findAll();
    $total = 0;

    // Calculer le total du panier en additionnant les prix de tous les produits
    foreach ($cart as $item) {
        $total += $item->getProduct()->getPrice();
    }
     
    $companyInfo = [
        'name' => 'Stubborn',
        'address' => 'Piccadilly Circus, London W1J 0DA, Royaume-Uni',
        'contact_email' => 'stubborn@blabla.com',
        'slogan' => "Don't compromise on your look",
    ];

    $request->getSession()->set('total', $total);

    // Passer les produits du panier à votre template Twig pour affichage
    return $this->render('cart/cart.html.twig', [
        'companyInfo' => $companyInfo,
        'total' => $total,
        'cart' => $cart,
    
    ]);
    
   }
 
}
    

