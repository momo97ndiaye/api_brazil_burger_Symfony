<?php 
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource( normalizationContext : ["groups"=>[
    "complement:read"
]],
collectionOperations: [
    'get',
],
itemOperations: []
)]

class Complement {

    private $id;


}

