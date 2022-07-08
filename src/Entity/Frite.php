<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FriteRepository::class)]
#[ApiResource( normalizationContext : ["groups"=>[
    "frite:read"
]],
denormalizationContext : ["groups"=>[
    "frite:write"
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
class Frite extends Produit
{
  

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frites')]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: FriteMenu::class)]
    private $friteMenus;


    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
        $this->friteMenus = new ArrayCollection();
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
            $menu->addFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFrite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, FriteMenu>
     */
    public function getFriteMenus(): Collection
    {
        return $this->friteMenus;
    }

    public function addFriteMenu(FriteMenu $friteMenu): self
    {
        if (!$this->friteMenus->contains($friteMenu)) {
            $this->friteMenus[] = $friteMenu;
            $friteMenu->setFrite($this);
        }

        return $this;
    }

    public function removeFriteMenu(FriteMenu $friteMenu): self
    {
        if ($this->friteMenus->removeElement($friteMenu)) {
            // set the owning side to null (unless already changed)
            if ($friteMenu->getFrite() === $this) {
                $friteMenu->setFrite(null);
            }
        }

        return $this;
    }

}
