<?php

namespace App\Entity;

use App\Repository\BillsSkeletonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BillsSkeletonRepository::class)
 */
class BillsSkeleton
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_edition;

    /**
     * @ORM\Column(type="integer")
     */
    private $siret_number;

    /**
     * @ORM\Column(type="integer")
     */
    private $client_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transmitter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_lodging;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_client;

    /**
     * @ORM\OneToMany(targetEntity=BillsContent::class, mappedBy="id_bill_skeleton")
     */
    private $id_bills_content;

    /**
     * @ORM\Column(type="date")
     */
    private $date_erasing;

    public function __construct()
    {
        $this->id_bills_content = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->date_edition;
    }

    public function setDateEdition(\DateTimeInterface $date_edition): self
    {
        $this->date_edition = $date_edition;

        return $this;
    }

    public function getSiretNumber(): ?int
    {
        return $this->siret_number;
    }

    public function setSiretNumber(int $siret_number): self
    {
        $this->siret_number = $siret_number;

        return $this;
    }

    public function getClientNumber(): ?int
    {
        return $this->client_number;
    }

    public function setClientNumber(int $client_number): self
    {
        $this->client_number = $client_number;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTransmitter(): ?string
    {
        return $this->transmitter;
    }

    public function setTransmitter(string $transmitter): self
    {
        $this->transmitter = $transmitter;

        return $this;
    }

    public function getNameLodging(): ?string
    {
        return $this->name_lodging;
    }

    public function setNameLodging(string $name_lodging): self
    {
        $this->name_lodging = $name_lodging;

        return $this;
    }

    public function getNameClient(): ?string
    {
        return $this->name_client;
    }

    public function setNameClient(string $name_client): self
    {
        $this->name_client = $name_client;

        return $this;
    }

    /**
     * @return Collection<int, BillsContent>
     */
    public function getIdBillsContent(): Collection
    {
        return $this->id_bills_content;
    }

    public function addIdBillsContent(BillsContent $idBillsContent): self
    {
        if (!$this->id_bills_content->contains($idBillsContent)) {
            $this->id_bills_content[] = $idBillsContent;
            $idBillsContent->setIdBillSkeleton($this);
        }

        return $this;
    }

    public function removeIdBillsContent(BillsContent $idBillsContent): self
    {
        if ($this->id_bills_content->removeElement($idBillsContent)) {
            // set the owning side to null (unless already changed)
            if ($idBillsContent->getIdBillSkeleton() === $this) {
                $idBillsContent->setIdBillSkeleton(null);
            }
        }

        return $this;
    }

    public function getDateErasing(): ?\DateTimeInterface
    {
        return $this->date_erasing;
    }

    public function setDateErasing(\DateTimeInterface $date_erasing): self
    {
        $this->date_erasing = $date_erasing;

        return $this;
    }
}
