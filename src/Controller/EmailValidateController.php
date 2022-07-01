<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmailValidateController extends AbstractController{
    public function __construct(EntityManagerInterface $enity,)
    {
        $this->entity = $entity;
    }

    public function __invoke(Request $request, UserRepository $userR, EntityManagerInterface $entity){
        $token = $request->get("token");
        //dd($token);
        $user = $userR->findOneBy(["token" => $token]);
        if(!$user){
            return new jsonResponse(["error" => "Invalid token"],Response::HTTP_BAD_REQUEST);
        }
        if($user->isIsEnable()){
            return new jsonResponse(["message" => "Votre compte est deja actif"],Response::HTTP_BAD_REQUEST);
        }
        if($user->getExpireAt() < new \DateTime()){
            return new jsonResponse(["message" => "clé expirée "],Response::HTTP_BAD_REQUEST);
        }
        $user->setIsEnable(true);
        $entity->flush();
        return new jsonResponse(["error" => "compte activée avec succés "],Response::HTTP_OK);
    }
}