<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\EmailValidateController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations:['VALIDATE'=> [
        'method'=>"PATCH",
        'deserialize'=> false,
        'path'=>'users/validate/{token}',
        "controller"=>EmailValidateController::class
    ],'POST'],
)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["gestionnaire" => "Gestionnaire", "client" =>
"Client","livreur"=>"Livreur"])]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["user:write","read"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["user:read","user:write","read"])]
    protected $email;

    #[ORM\Column(type: 'json')]
    #[Groups(["user:read","user:write"])]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(["user:write"])]
    protected $password;


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["user:read","user:write"])]
    protected $nomComplet;

    #[SerializedName("password")]
    #[Groups(["user:write"])]   
    protected $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    protected $token;

    #[ORM\Column(type: 'datetime')]
    protected $expireAt;

    #[ORM\Column(type: 'boolean')]
    protected $isEnable;

    public function __construct(){
        $this->isEnable = false;
        $this->generateToken();
        $role = get_called_class();
        $role = explode('\\', $role);
        $role = strtoupper($role[2]);
        return $this->roles[] = "ROLE_".$role;
    }
    public function generateToken() {
        $this->expireAt = new \DateTime('+ 1day');
        $this->token = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(random_bytes(128)));
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }
}
