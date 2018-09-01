<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $artifactNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductCategory", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cataloguePage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * @ORM\Column(type="string", length=8000, nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductOrderItem", mappedBy="product")
     */
    private $productOrderItems;

    public function __construct()
    {
        $this->productOrderItems = new ArrayCollection();
    }

    public function getId()
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

    public function getArtifactNumber(): ?int
    {
        return $this->artifactNumber;
    }

    public function setArtifactNumber(int $artifactNumber): self
    {
        $this->artifactNumber = $artifactNumber;

        return $this;
    }

    public function getCategory(): ?ProductCategory
    {
        return $this->category;
    }

    public function setCategory(ProductCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCataloguePage(): ?int
    {
        return $this->cataloguePage;
    }

    public function setCataloguePage(int $cataloguePage): self
    {
        $this->cataloguePage = $cataloguePage;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection|ProductOrderItem[]
     */
    public function getProductOrderItems(): ?Collection
    {
        return $this->productOrderItems;
    }

    public function addProductOrderItem(ProductOrderItem $productOrderItem): self
    {
        if (!$this->productOrderItems->contains($productOrderItem)) {
            $this->productOrderItems[] = $productOrderItem;
            $productOrderItem->setProduct($this);
        }

        return $this;
    }

    public function removeProductOrderItem(ProductOrderItem $productOrderItem): self
    {
        if ($this->productOrderItems->contains($productOrderItem)) {
            $this->productOrderItems->removeElement($productOrderItem);
            // set the owning side to null (unless already changed)
            if ($productOrderItem->getProduct() === $this) {
                $productOrderItem->setProduct(null);
            }
        }

        return $this;
    }

}
