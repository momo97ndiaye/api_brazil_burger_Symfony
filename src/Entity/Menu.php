<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    normalizationContext : ["groups"=>[
        "menu:read"
    ]],
    denormalizationContext : ["groups"=>[
        "menu:write"
    ]],
    collectionOperations: [
    
    'get',
    'post'
],
itemOperations: [
    'get',
    'put',
    'patch'
],)]
class Menu extends Produit
{

    #[Groups(["menu:write","menu:read"])]
    #[ORM\ManyToMany(targetEntity: Burger::class, mappedBy: 'menus')]
    protected $burgers;

    #[Groups(["menu:write","menu:read"])]
    #[ORM\ManyToMany(targetEntity: Frite::class, inversedBy: 'menus')]
    protected $frites;

    #[Groups(["menu:write","menu:read"])]
    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'menus')]
    protected $taille;

   
    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->frites = new ArrayCollection();
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->addMenu($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            $burger->removeMenu($this);
        }

        return $this;
    }

  

    /**
     * @return Collection<int, Frite>
     */
    public function getFrites(): Collection
    {
        return $this->frites;
    }

    public function addFrite(Frite $frite): self
    {
        if (!$this->frites->contains($frite)) {
            $this->frites[] = $frite;
        }

        return $this;
    }

    public function removeFrite(Frite $frite): self
    {
        $this->frites->removeElement($frite);

        return $this;
    }

    public function getTaille(): ?TailleBoisson
    {
        return $this->taille;
    }

    public function setTaille(?TailleBoisson $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

   
}
