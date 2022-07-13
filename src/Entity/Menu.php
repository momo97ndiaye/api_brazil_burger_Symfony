<?php

namespace App\Entity;

use App\Entity\Produit;
use App\Entity\FriteMenu;
use App\Entity\MenuBurger;
use App\Entity\BoissonMenu;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use App\Controller\MenuPersistController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
/* #[ApiResource(
    normalizationContext : ["groups"=>[
        "menu:read"
    ]],
    denormalizationContext : ["groups"=>[
        "menu:write"
    ]],
    collectionOperations:['POST','POSTMENU'=> [
        'method'=>"POST",
        'deserialize'=> false,
        'path'=>'postmenu',
        "controller"=>MenuPersistController::class,
    ]
    ],
itemOperations: [
    'get',
    'put',
    'patch'
],)] */
class Menu extends Produit
{

    #[Groups(["user:rea»d","user:write","write","read","frite:write","frite:read","menu:read","menu:write","catalogue:read","burger:write","burger:read","boisson:write","boisson:read"])]
    protected $image;

    #[Groups(["user:read","user:write","write","read","frite:write","frite:read","menu:read","menu:write","catalogue:read","burger:write","burger:read","boisson:write","boisson:read"])]
    protected $nom;

    #[Groups(["menu:write","menu:read"])]
    #[SerializedName('burgers')]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade: ["persist"])]
    private $menuBurgers;

    #[Groups(["menu:write","menu:read"])]
    #[SerializedName('frites')]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: FriteMenu::class,cascade: ["persist"])]
    private $friteMenus;

    #[Groups(["menu:write","menu:read"])]
    #[SerializedName('tailles')]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: BoissonMenu::class,cascade: ["persist"])]
    private $boissonMenus;

    public function __construct()
    {
        $this->menuBurgers = new ArrayCollection();
        $this->friteMenus = new ArrayCollection();
        $this->boissonMenus = new ArrayCollection();
    }


    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }


    public function addBurger($burger,$quantite){
        $menuBurgers = new MenuBurger();
        $menuBurgers->setBurger($burger);
        $menuBurgers->setQuantite($quantite);
        $menuBurgers->setMenu($this);
        $this->addMenuBurger($menuBurgers);
    }

    public function addFrite($frite,$quantite){
        $menufrite = new FriteMenu();
        $menufrite->setFrite($frite);
        $menufrite->setQuantite($quantite);
        $menufrite->setMenu($this);
        $this->addFriteMenu($menufrite);
    }

    public function addTaille($taille,$quantite){
        $menuboisson = new BoissonMenu();
        $menuboisson->setTaille($taille);
        $menuboisson->setQuantite($quantite);
        $menuboisson->setMenu($this);
        $this->addBoissonMenu($menuboisson);
    }


    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
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
            $friteMenu->setMenu($this);
        }

        return $this;
    }

    public function removeFriteMenu(FriteMenu $friteMenu): self
    {
        if ($this->friteMenus->removeElement($friteMenu)) {
            // set the owning side to null (unless already changed)
            if ($friteMenu->getMenu() === $this) {
                $friteMenu->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoissonMenu>
     */
    public function getBoissonMenus(): Collection
    {
        return $this->boissonMenus;
    }

    public function addBoissonMenu(BoissonMenu $boissonMenu): self
    {
        if (!$this->boissonMenus->contains($boissonMenu)) {
            $this->boissonMenus[] = $boissonMenu;
            $boissonMenu->setMenu($this);
        }

        return $this;
    }

    public function removeBoissonMenu(BoissonMenu $boissonMenu): self
    {
        if ($this->boissonMenus->removeElement($boissonMenu)) {
            // set the owning side to null (unless already changed)
            if ($boissonMenu->getMenu() === $this) {
                $boissonMenu->setMenu(null);
            }
        }

        return $this;
    }


}
