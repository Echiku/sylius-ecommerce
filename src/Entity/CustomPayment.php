<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomPaymentRepository;
use Sylius\Component\Resource\Model\ResourceInterface;

#[ORM\Entity(repositoryClass: CustomPaymentRepository::class)]
#[ORM\Table(name: 'sylius_customer_payment')]
class CustomPayment 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?string $paymentId = null;

    #[ORM\Column(nullable: true)]
    private ?string $payerId = null;

    #[ORM\Column(nullable: true)]
    private ?string $payerEmail = null;

    #[ORM\Column(nullable: true)]
    private ?string $amount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $currency = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $purchasedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $paymentStatus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    public function setPaymentId(?string $paymentId): static
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    public function getPayerId(): ?string
    {
        return $this->payerId;
    }

    public function setPayerId(?string $payerId): static
    {
        $this->payerId = $payerId;

        return $this;
    }

    public function getPayerEmail(): ?string
    {
        return $this->payerEmail;
    }

    public function setPayerEmail(?string $payerEmail): static
    {
        $this->payerEmail = $payerEmail;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getPurchasedAt(): ?\DateTimeInterface
    {
        return $this->purchasedAt;
    }

    public function setPurchasedAt(?\DateTimeInterface $purchasedAt): static
    {
        $this->purchasedAt = $purchasedAt;

        return $this;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(?string $paymentStatus): static
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }
}
