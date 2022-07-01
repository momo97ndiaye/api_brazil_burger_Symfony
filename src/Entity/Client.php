<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use App\Controller\EmailValidateController;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    normalizationContext : ["groups"=>[
        "user:read"
    ]],
    denormalizationContext : ["groups"=>[
        "user:write"
    ]],
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'put',
        'patch'
    ],
)]
class Client extends User 
{
  
    
}
