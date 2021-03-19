<?php

namespace App\Entity\Procost;

use App\Entity\User;
use App\Repository\Procost\MetierRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;

/**
 * @ORM\Entity(repositoryClass=MetierRepository::class)
 */
class Metier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany (targetEntity="App\Entity\User", mappedBy="metier")
     */
    private $users;
    public function __construct(){
        $this->users=new Collection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    /**
     * @return Collection|User[]
     */
    public function getUsers():Collection
    {
        return $this->users;
    }
    public function addUser(User $user):self
    {
        if(!$this->users->contains($user)){
            $this->users[]=$user;
            $user->setMetier($this);
        }
        return $this;
    }
    public function removeUser(User $user):self
    {
        if($this->users->contains($user)){
            $this->users->removeElement($user);
        }
        return $this;
    }
}
