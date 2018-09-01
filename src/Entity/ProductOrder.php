<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductOrderRepository")
 */
class ProductOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="productOrders")
     */
    private $customer;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductOrderItem", mappedBy="productOrder", cascade={"persist"}))
     */
    private $productOrderItems;

    public function __construct(Customer $customer=null)
    {
        $this->productOrderItems = new ArrayCollection();
        $this->customer = $customer;
        $this->orderDate = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * @return Collection|ProductOrderItem[]
     */
    public function getProductOrderItems(): Collection
    {
        return $this->productOrderItems;
    }

    public function addProductOrderItem(ProductOrderItem $productOrderItem): self
    {
        if (!$this->productOrderItems->contains($productOrderItem)) {
            $this->productOrderItems[] = $productOrderItem;
            $productOrderItem->setProductOrder($this);
        }

        return $this;
    }

    public function removeProductOrderItem(ProductOrderItem $productOrderItem): self
    {
        if ($this->productOrderItems->contains($productOrderItem)) {
            $this->productOrderItems->removeElement($productOrderItem);
            // set the owning side to null (unless already changed)
            if ($productOrderItem->getProductOrder() === $this) {
                $productOrderItem->setProductOrder(null);
            }
        }

        return $this;
    }
}
