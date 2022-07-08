<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonMenuRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonMenuRepository::class)]
class BoissonMenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["menu:write","menu:read"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $quantite;

    #[Groups(["menu:write","menu:read"])]
    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'boissonMenus')]
    private $taille;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'boissonMenus')]
    private $menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

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


    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
