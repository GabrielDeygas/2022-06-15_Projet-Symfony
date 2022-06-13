<?php

namespace App\Entity;

use App\Repository\BookingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingsRepository::class)
 */
class Bookings
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
    private $nb_adults;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_children;

    /**
     * @ORM\ManyToOne(targetEntity=Lodging::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_lodging;

    /**
     * @ORM\OneToMany(targetEntity=Extras::class, mappedBy="booking")
     */
    private $extras;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="bookings",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="date")
     */
    private $date_departure;

    /**
     * @ORM\Column(type="date")
     */
    private $date_arrival;

    public function __construct()
    {
        $this->extras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbAdults(): ?int
    {
        return $this->nb_adults;
    }

    public function setNbAdults(int $nb_adults): self
    {
        $this->nb_adults = $nb_adults;

        return $this;
    }

    public function getNbChildren(): ?int
    {
        return $this->nb_children;
    }

    public function setNbChildren(int $nb_children): self
    {
        $this->nb_children = $nb_children;

        return $this;
    }

    public function getIdLodging(): ?Lodging
    {
        return $this->id_lodging;
    }

    public function setIdLodging(?Lodging $id_lodging): self
    {
        $this->id_lodging = $id_lodging;

        return $this;
    }

    /**
     * @return Collection<int, Extras>
     */
    public function getExtras(): Collection
    {
        return $this->extras;
    }

    public function addExtra(Extras $extra): self
    {
        if (!$this->extras->contains($extra)) {
            $this->extras[] = $extra;
            $extra->setBooking($this);
        }

        return $this;
    }

    public function removeExtra(Extras $extra): self
    {
        if ($this->extras->removeElement($extra)) {
            // set the owning side to null (unless already changed)
            if ($extra->getBooking() === $this) {
                $extra->setBooking(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDateDeparture(): ?\DateTimeInterface
    {
        return $this->date_departure;
    }

    public function setDateDeparture(\DateTimeInterface $date_departure): self
    {
        $this->date_departure = $date_departure;

        return $this;
    }

    public function getDateArrival(): ?\DateTimeInterface
    {
        return $this->date_arrival;
    }

    public function setDateArrival(\DateTimeInterface $date_arrival): self
    {
        $this->date_arrival = $date_arrival;

        return $this;
    }

}
