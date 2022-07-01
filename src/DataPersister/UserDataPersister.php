<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct( EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder, MailService $mailService)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        $this->mailService = $mailService;

    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getPlainPassword()) {
            $password = $this->encoder->hashPassword($data,$data->getPlainPassword());
            $data->setPassword($password);
            $data->eraseCredentials();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            $this->mailService->envoiMail($data);
        }        
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}