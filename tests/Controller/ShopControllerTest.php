<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Token;


class ShopControllerTest extends WebTestCase
{
    public function testAddToCart()
    {
        $client = static::createClient();

        // Simuler une requête avec la taille 'XS'
        $crawler = $client->request('GET', '/add-to-cart/1?size=XS');

        // Vérifier que la requête s'est bien déroulée
        $this->assertResponseRedirects('/products');

        // Simuler une requête avec la taille 'M' pour un produit ayant du stock
        $crawler = $client->request('GET', '/add-to-cart/2?size=M');
        
        

    }
   


}
