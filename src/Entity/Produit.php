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

    #[Groups(["user:read","user:write","write","read","frite:write","frite:read","catalogue:read","burger:write","burger:read","boisson:write","boisson:read"])]
    #[ORM\Column(type: 'string', length: 255 , nullable: true)]
    protected $nom;

    #[Groups(["user:read","user:write","write","read","menu:read","menu:write","frite:write","frite:read","catalogue:read","burger:write","burger:read","boisson:write","boisson:read"])]
    #[ORM\Column(type: 'float', nullable: true)]
    protected $prix=1000;

    #[Groups(["user:read","user:write","write","read","frite:write","frite:read","catalogue:read","burger:write","burger:read","boisson:write","boisson:read"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $image;

    #[Groups(["user:read","user:write","write","read","menu:read","menu:write","frite:write","frite:read","catalogue:read","burger:write","burger:read","boisson:write","boisson:read"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    protected $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    protected $ligneCommandes;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')]
    protected $commandes;

    #[Groups(["user:read","user:write","menu:read","menu:write","write","read","frite:write","frite:read","catalogue:read","burger:write","burger:read"])]
    #[ORM\Column(type: 'boolean', nullable: true)]
    protected $isEtat=true;

 
    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
        $this->commandes = new ArrayCollection();
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

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(?bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }


}
