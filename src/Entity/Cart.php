<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    #[ORM\Column(type: "string", length: 255)]
    private $size;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;
        return $this;
    }

    // Méthodes pour ajouter et retirer des produits du panier
    public function addToCart(Product $product, string $size): void
    {
        switch ($size) {
            case 'XS':
                if ($product->getStockXS() > 0) {
                    $this->product = $product;
                    $this->size = $size;
                    $product->setStockXS($product->getStockXS() - 1);
                }
                break;
            case 'S':
                if ($product->getStockS() > 0) {
                    $this->product = $product;
                    $this->size = $size;
                    $product->setStockS($product->getStockS() - 1);
                }
                break;
            case 'M':
                if ($product->getStockM() > 0) {
                    $this->product = $product;
                    $this->size = $size;
                    $product->setStockM($product->getStockM() - 1);
                }
                break;
            case 'L':
                if ($product->getStockL() > 0) {
                    $this->product = $product;
                    $this->size = $size;
                    $product->setStockL($product->getStockL() - 1);
                }
                break;
            case 'XL':
                if ($product->getStockXL() > 0) {
                    $this->product = $product;
                    $this->size = $size;
                    $product->setStockXL($product->getStockXL() - 1);
                }
                break;
            default:
                // Gérer le cas où la taille n'est pas valide
                break;
        }
    }

    public function removeFromCart(): void
    {
        switch ($this->size) {
            case 'XS':
                $this->product->setStockXS($this->product->getStockXS() + 1);
                break;
            case 'S':
                $this->product->setStockS($this->product->getStockS() + 1);
                break;
            case 'M':
                $this->product->setStockM($this->product->getStockM() + 1);
                break;
            case 'L':
                $this->product->setStockL($this->product->getStockL() + 1);
                break;
            case 'XL':
                $this->product->setStockXL($this->product->getStockXL() + 1);
                break;
            default:
                // Gérer le cas où la taille n'est pas valide
                break;
        }
        $this->product = null;
        $this->size = null;
    }
}
