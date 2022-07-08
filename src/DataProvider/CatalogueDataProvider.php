<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $itemExtensions;
    private $managerRegistry;

    public function __construct(MenuRepository $menuRepo,BurgerRepository $burgerRepo)
    {
      $this->menuRepo = $menuRepo;
      $this->burgerRepo = $burgerRepo;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        // Retrieve the blog post collection from somewhere
        $catalogue=[];
        $catalogue["burgers"] =  $this->burgerRepo->findAll();
        $catalogue["menus"  ] =  $this->menuRepo->findAll();
        return $catalogue;

    }
}