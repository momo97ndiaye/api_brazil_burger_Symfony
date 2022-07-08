<?php 
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource( normalizationContext : ["groups"=>[
    "catalogue:read"
]],
collectionOperations: [
    'get',
],
itemOperations: []
)]

class Catalogue {

    private $id;

    

}

