<?php

namespace App\Entity;

use App\Repository\LodgingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=LodgingRepository::class)
 * @Vich\Uploadable()
 */
class Lodging
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=TypeLodging::class, inversedBy="lodgings", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_typelodging;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lodgings", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_user;

    /**
     * @ORM\OneToMany(targetEntity=Bookings::class, mappedBy="id_lodging", cascade={"persist"})
     */
    private $bookings;

    /**
     * @var string\null
     * @ORM\Column (type="string", length=255)
     */
    private $filename;

    /**
     * @var File\null
     * @Vich\UploadableField(mapping="Lodging_pic", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column (type="date")
     */
    private $updateAt;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }


    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): ?self
    {
        $this->imageFile = $imageFile;
        if($this->imageFile instanceof UploadedFile){
            $this->updateAt = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt($updateAt): self
    {
        $this->updateAt = $updateAt;
        return $this;
    }



    public function getId(): ?int
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

    public function getIdTypelodging(): ?TypeLodging
    {
        return $this->id_typelodging;
    }

    public function setIdTypelodging(?TypeLodging $id_typelodging): self
    {
        $this->id_typelodging = $id_typelodging;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * @return Collection<int, Bookings>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Bookings $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setIdLodging($this);
        }

        return $this;
    }

    public function removeBooking(Bookings $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getIdLodging() === $this) {
                $booking->setIdLodging(null);
            }
        }

        return $this;
    }
}
