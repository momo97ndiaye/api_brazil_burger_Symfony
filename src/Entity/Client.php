<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User 
{
    
}
