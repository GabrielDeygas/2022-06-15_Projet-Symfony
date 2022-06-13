<?php

namespace App\Entity;

use App\Repository\ExtrasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExtrasRepository::class)
 */
class Extras
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
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=ExtraType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $extra_type;

    /**
     * @ORM\ManyToOne(targetEntity=Bookings::class, inversedBy="extras")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking;

    public function __construct(){}

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExtraType(): ?ExtraType
    {
        return $this->extra_type;
    }

    public function setExtraType(?ExtraType $extra_type): self
    {
        $this->extra_type = $extra_type;

        return $this;
    }

    public function getBooking(): ?Bookings
    {
        return $this->booking;
    }

    public function setBooking(?Bookings $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

}
