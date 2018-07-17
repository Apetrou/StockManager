<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CustomerArea", inversedBy="customers")
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CustomerCity", inversedBy="customers")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Animal", inversedBy="customers")
     */
    private $animals;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CustomerRisk", inversedBy="customers")
     */
    private $risk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CustomerPayment", inversedBy="customers")
     */
    private $paymentMethod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shippingMethod;

    /**
     * @ORM\Column(type="string", length=8000, nullable=true)
     */
    private $comments;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getArea(): ?CustomerArea
    {
        return $this->area;
    }

    public function setArea(?CustomerArea $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getCity(): ?CustomerCity
    {
        return $this->city;
    }

    public function setCity(?CustomerCity $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAnimals(): ?animal
    {
        return $this->animals;
    }

    public function setAnimals(?animal $animals): self
    {
        $this->animals = $animals;

        return $this;
    }

    public function getTelephoneNumber(): ?string
    {
        return $this->telephoneNumber;
    }

    public function setTelephoneNumber(?string $telephoneNumber): self
    {
        $this->telephoneNumber = $telephoneNumber;

        return $this;
    }

    public function getRisk(): ?CustomerRisk
    {
        return $this->risk;
    }

    public function setRisk(?CustomerRisk $risk): self
    {
        $this->risk = $risk;

        return $this;
    }

    public function getPaymentMethod(): ?CustomerPayment
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?CustomerPayment $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getShippingMethod(): ?string
    {
        return $this->shippingMethod;
    }

    public function setShippingMethod(?string $shippingMethod): self
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }
}
