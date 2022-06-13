<?php

namespace App\Entity;

use App\Repository\BillsContentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BillsContentRepository::class)
 */
class BillsContent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $bill_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=BillsSkeleton::class, inversedBy="id_bills_content")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_bill_skeleton;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBillNumber(): ?int
    {
        return $this->bill_number;
    }

    public function setBillNumber(int $bill_number): self
    {
        $this->bill_number = $bill_number;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getIdBillSkeleton(): ?BillsSkeleton
    {
        return $this->id_bill_skeleton;
    }

    public function setIdBillSkeleton(?BillsSkeleton $id_bill_skeleton): self
    {
        $this->id_bill_skeleton = $id_bill_skeleton;

        return $this;
    }
}
