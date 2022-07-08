<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Repository\UserRepository;
use App\Repository\FriteRepository;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TailleBoissonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuPersistController extends AbstractController{
    public function __construct(EntityManagerInterface $entity)
    {
        $this->entity = $entity;
    }

    public function __invoke(Request $request,EntityManagerInterface $entity,BurgerRepository $burgerRepo,FriteRepository $friteRepo,TailleBoissonRepository $tailleRepo){
        $content = json_decode($request->getContent());
        if($content->nom==""){
            return $this->json('nom requis',400);
        }
        if($content->image==""){
            return $this->json('image requis',400);
        }

        $menu= (new Menu())
            ->setNom($content->nom)
            ->setImage($content->image)
        ;
        //dd($content->burgers["quantite"]);
        foreach($content->burgers as $menuBurgers){
            $burger= $burgerRepo->find($menuBurgers->burger);
            if($burger){
                $menu->addBurger($burger,$menuBurgers->quantite);
            }
        }
        foreach($content->frites as $menufrites){
            $frite= $friteRepo->find($menufrites->frite);
            if($frite){
                $menu->addFrite($frite,$menufrites->quantite);
            }
        }
        foreach($content->boissons as $menuBoissons){
            $taille= $tailleRepo->find($menuBoissons->taille);
            if($taille){
                $menu->addTaille($taille,$menuBoissons->quantite);
            }
        }
        $this->entity->persist($menu);
        //dd($menu);
        $this->entity->flush();
        //dd($menuBurgers);
    }
        
}