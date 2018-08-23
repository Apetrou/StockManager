<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductOrderItemRepository")
 */
class ProductOrderItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="productOrderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $productQuantity;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductOrder", inversedBy="productOrderItems")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $productOrder;

    public function __construct(Product $product, $productQuantity, $cost)
    {
        $this->product = $product;
        $this->productQuantity = $productQuantity;
        $this->cost = $cost;
    }

    public function getId()
    {
        return $this->id;
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

    public function getProductQuantity(): ?int
    {
        return $this->productQuantity;
    }

    public function setProductQuantity(int $productQuantity): self
    {
        $this->productQuantity = $productQuantity;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getProductOrder(): ?ProductOrder
    {
        return $this->productOrder;
    }

    public function setProductOrder(?ProductOrder $productOrder): self
    {
        $this->productOrder = $productOrder;

        return $this;
    }
}
