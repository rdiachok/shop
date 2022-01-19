<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=100)
     * @Assert\Length(min = 6, max = 50, minMessage = "Email must be at least {{ limit }} characters long", maxMessage = "Email cannot be longer than {{ limit }} characters")
     */

    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min = 2, max = 50, minMessage = "Name must be at least {{ limit }} characters long", maxMessage = "Name cannot be longer than {{ limit }} characters")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min = 2, max = 50, minMessage = "Last name must be at least {{ limit }} characters long", maxMessage = "Last name cannot be longer than {{ limit }} characters")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", columnDefinition="enum('admin', 'manager', 'salesman', 'customer')")
     */
    private $action;


    /**)
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="userAdd")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=Orders::class, mappedBy="customer", cascade={"all"})
     */
    private $orders;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return Collection|Products[]|null
     */

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUserAdd($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getUserAdd() === $this) {
                $product->setUserAdd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Orders[]|null
     */

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }
}
