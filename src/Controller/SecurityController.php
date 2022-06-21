<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class SecurityController extends AbstractController
{
    #[Route(path:'/api/login', name: 'api_login', methods:['POST','GET'])] 
    public function login(){
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getEmail(),
            'roles' => $user->getRoles()
            ]);
    }
}
