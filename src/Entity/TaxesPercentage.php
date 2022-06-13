<?php

namespace App\Entity;

use App\Repository\TaxesPercentageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaxesPercentageRepository::class)
 */
class TaxesPercentage
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
    private $type_taxes;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $percent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTaxes(): ?string
    {
        return $this->type_taxes;
    }

    public function setTypeTaxes(string $type_taxes): self
    {
        $this->type_taxes = $type_taxes;

        return $this;
    }

    public function getPercent(): ?string
    {
        return $this->percent;
    }

    public function setPercent(string $percent): self
    {
        $this->percent = $percent;

        return $this;
    }
}
