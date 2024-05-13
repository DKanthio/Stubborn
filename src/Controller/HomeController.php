<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\FeaturedProduct;


class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
     
    }


    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
      
        // Récupérer les produits mis en avant depuis la base de données
        $featuredProducts = $this->entityManager->getRepository(FeaturedProduct::class)->findAll();
        $companyInfo = [
            'name' => 'Stubborn',
            'address' => 'Piccadilly Circus, London W1J 0DA, Royaume-Uni',
            'contact_email' => 'stubborn@blabla.com', // Ajout de la clé contact_email
            'slogan' => "Don't compromise on your look", // Ajout du slogan
        ];

        // Rendu du modèle Twig en transmettant companyInfo et featuredProducts
        return $this->render('home/index.html.twig', [
            'companyInfo' => $companyInfo,
            'featuredProducts' => $featuredProducts,
        ]);
    }
}



