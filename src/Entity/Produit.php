<?php

namespace App\Entity;

use App\Entity\Gestionnaire;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource()]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["boisson" => "Boisson","frite" => "Frite", "menu" =>
"Menu","burger"=>"Burger"])]
class Produit
{
    #[Groups(["menu:write","menu:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[Groups(["user:read","user:write","write","read","menu:write","frite:write","frite:read"])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nom;

    #[Groups(["user:read","user:write","write","read","menu:write","frite:write","frite:read"])]
    #[ORM\Column(type: 'float')]
    protected $prix;

    #[Groups(["user:read","user:write","write","read","menu:write","frite:write","frite:read"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $image;

    #[Groups(["user:read","user:write","write","read","menu:write","menu:read","frite:write","frite:read"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

 
    public function __construct()
    {
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }


}
