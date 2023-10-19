<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderProduitRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\ResourceInterface;


#[ORM\Entity(repositoryClass: OrderProduitRepository::class)]
#[ORM\Table(name: 'sylius_order_produit')]
class OrderProduit 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $itemsTotal = null;

    #[ORM\Column(nullable: true)]
    private ?float $estimationCout = null;

    #[ORM\Column(nullable: true)]
    private ?float $taxes = null;

    #[ORM\Column(nullable: true)]
    private ?float $orderTotal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?int $quantite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomProduit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $orderAt = null;

    #[ORM\OneToMany(mappedBy: 'orderProduit', targetEntity: Client::class)]
    private Collection $client;



    public function __construct()
    {
        $this->client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemsTotal(): ?float
    {
        return $this->itemsTotal;
    }

    public function setItemsTotal(?float $itemsTotal): static
    {
        $this->itemsTotal = $itemsTotal;

        return $this;
    }

    public function getEstimationCout(): ?float
    {
        return $this->estimationCout;
    }

    public function setEstimationCout(?float $estimationCout): static
    {
        $this->estimationCout = $estimationCout;

        return $this;
    }

    public function getTaxes(): ?float
    {
        return $this->taxes;
    }

    public function setTaxes(?float $taxes): static
    {
        $this->taxes = $taxes;

        return $this;
    }

    public function getOrderTotal(): ?float
    {
        return $this->orderTotal;
    }

    public function setOrderTotal(?float $orderTotal): static
    {
        $this->orderTotal = $orderTotal;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(?string $nomProduit): static
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getOrderAt(): ?\DateTimeInterface
    {
        return $this->orderAt;
    }

    public function setOrderAt(?\DateTimeInterface $orderAt): static
    {
        $this->orderAt = $orderAt;

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Client $client): static
    {
        if (!$this->client->contains($client)) {
            $this->client->add($client);
            $client->setOrderProduit($this);
        }

        return $this;
    }

    public function removeClient(Client $client): static
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getOrderProduit() === $this) {
                $client->setOrderProduit(null);
            }
        }

        return $this;
    }
}
