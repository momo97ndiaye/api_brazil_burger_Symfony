<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(  normalizationContext : ["groups"=>[
    "taille:read"
]],
denormalizationContext : ["groups"=>[
    "taille:write"
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
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[Groups(["taille:read","taille:write"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $size;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    protected $boissons;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: Menu::class)]
    protected $menus;

    #[Groups(["taille:read","taille:write"])]
    #[ORM\Column(type: 'float', nullable: true)]
    private $prix;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setTaille($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getTaille() === $this) {
                $menu->setTaille(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
