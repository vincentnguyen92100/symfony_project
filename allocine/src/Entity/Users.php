<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length (min="5")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length (min="8", minMessage="Your must have 8 caracter minimum")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message= "Your password confirmation should be similar of your password")
     */
    
    public $confirm_password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banned;

    /**
     * @ORM\Column(type="boolean")
     */
    private $unsubscribe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Liste", mappedBy="users", orphanRemoval=true)
     */
    private $listes;

    public function __construct()
    {
        $this->listes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    public function getUnsubscribe(): ?bool
    {
        return $this->unsubscribe;
    }

    public function setUnsubscribe(bool $unsubscribe): self
    {
        $this->unsubscribe = $unsubscribe;

        return $this;
    }

    public function eraseCredentials(){}

        public function getSalt(){}

            public function getRoles(){
                return ['ROLE_USER'];
            }

            /**
             * @return Collection|Liste[]
             */
            public function getListes(): Collection
            {
                return $this->listes;
            }

            public function addListe(Liste $liste): self
            {
                if (!$this->listes->contains($liste)) {
                    $this->listes[] = $liste;
                    $liste->setUsers($this);
                }

                return $this;
            }

            public function removeListe(Liste $liste): self
            {
                if ($this->listes->contains($liste)) {
                    $this->listes->removeElement($liste);
                    // set the owning side to null (unless already changed)
                    if ($liste->getUsers() === $this) {
                        $liste->setUsers(null);
                    }
                }

                return $this;
            }
}
