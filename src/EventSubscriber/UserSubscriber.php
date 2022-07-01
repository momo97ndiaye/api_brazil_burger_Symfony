<?php

namespace App\EventSubscriber;

use App\Entity\Produit;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();
    }
    public static function getSubscribedEvents():array{
        return [
            Events::prePersist
        ];
    }

    public function getGestionnaire(){
        if(null === $token = $this->token){
            return null;
        }
        if(!is_object($gestionnaire=$token->getUser())){
            return null;
        }
        return $gestionnaire;
    }

    public function prePersist(LifecycleEventArgs $args){
        if($args->getObject() instanceof Produit){
            $args->getObject()->setGestionnaire($this->getGestionnaire()); 
        }
    }
   
}
