<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $price;

    #[ORM\Column(type: "string", length: 255)]
    private string $image;

    #[ORM\Column(type: "integer")]
    private int $stockXS = 2;

    #[ORM\Column(type: "integer")]
    private int $stockS = 2;

    #[ORM\Column(type: "integer")]
    private int $stockM = 2;

    #[ORM\Column(type: "integer")]
    private int $stockL = 2;

    #[ORM\Column(type: "integer")]
    private int $stockXL = 2;

    public static function getDefaultProducts(): array
    {
        return [
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
    }

    // Méthode pour créer des produits à partir des données par défaut
    public static function createProducts(): array
    {
        $products = [];
        foreach (self::getDefaultProducts() as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setImage($data['image']);
            $product->setStockXS(2);
            $product->setStockS(2);
            $product->setStockM(2);
            $product->setStockL(2);
            $product->setStockXL(2);
            $products[] = $product;
        }
        return $products;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    // Méthodes getters et setters pour les stocks
    public function getStockXS(): int
    {
        return $this->stockXS;
    }

    public function setStockXS(int $stockXS): self
    {
        $this->stockXS = $stockXS;
        return $this;
    }

    public function getStockS(): int
    {
        return $this->stockS;
    }

    public function setStockS(int $stockS): self
    {
        $this->stockS = $stockS;
        return $this;
    }

    public function getStockM(): int
    {
        return $this->stockM;
    }

    public function setStockM(int $stockM): self
    {
        $this->stockM = $stockM;
        return $this;
    }

    public function getStockL(): int
    {
        return $this->stockL;
    }

    public function setStockL(int $stockL): self
    {
        $this->stockL = $stockL;
        return $this;
    }

    public function getStockXL(): int
    {
        return $this->stockXL;
    }

    public function setStockXL(int $stockXL): self
    {
        $this->stockXL = $stockXL;
        return $this;
    }
   
}
