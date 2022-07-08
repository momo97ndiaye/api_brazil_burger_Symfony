<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource()]

class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;


    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]    
    protected $zone;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomQuartier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getNomQuartier(): ?string
    {
        return $this->nomQuartier;
    }

    public function setNomQuartier(string $nomQuartier): self
    {
        $this->nomQuartier = $nomQuartier;

        return $this;
    }
}
