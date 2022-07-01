<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource( /*  normalizationContext : ["groups"=>[
    "user:read"
]],
denormalizationContext : ["groups"=>[
    "user:write"
]], */
collectionOperations: [
    'get',
    'post'=>[
        "denormalization_context"=>["groups"=>["write"]],
        "normalization_context"=>["groups"=>["read"]]
    ]
],
itemOperations: [
    'get',
    'put',
    'patch'
],)]
class Burger extends Produit
{
    #[Groups(["write","read"])]
    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'burgers')]
    protected $menus;


    public function __construct()
    {
        $this->menus = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }

}
