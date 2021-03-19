<?php

namespace App\Entity\Procost;

use App\Repository\Procost\ProjetRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_At;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_livraison;

    /**
     * @ORM\OneToMany (targetEntity="App\Entity\Procost\ProjetUser", mappedBy="projet")
     */
    private $projetusers;

    public function __construct()
    {
        $this->created_At=new \DateTime();
        $this->users=new Collection();
        $this->projetusers=new Collection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_At;
    }

    public function setCreatedAt(\DateTimeInterface $created_At): self
    {
        $this->created_At = $created_At;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(?\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }
    /**
     * @return Collection|ProjetUser[]
     */
    public function getProjetUsers():Collection
    {
        return $this->projetusers;
    }
    public function addUser(ProjetUser $projetUser):self
    {
        if(!$this->projetusers->contains($projetUser)){
            $this->projetusers[]=$projetUser;
            $projetUser->setProjet($this);
        }
        return $this;
    }
    public function removeUser(ProjetUser $projetUser):self
    {
        if($this->projetusers->contains($projetUser)){
            $this->projetusers->removeElement($projetUser);
        }
        return $this;
    }


}
