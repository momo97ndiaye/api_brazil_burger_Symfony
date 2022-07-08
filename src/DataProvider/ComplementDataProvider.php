<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\FriteRepository;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{

    public function __construct(FriteRepository $friteRepo,BoissonRepository $boissonRepo)
    {
      $this->friteRepo = $friteRepo;
      $this->boissonRepo = $boissonRepo;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        // Retrieve the blog post collection from somewhere
        $complement=[];
        $complement["boissons"] =  $this->boissonRepo->findAll();
        $complement["frites"  ] =  $this->friteRepo->findAll();
        return $complement;

    }
}