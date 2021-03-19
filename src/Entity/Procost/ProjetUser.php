<?php


namespace App\Entity\Procost;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;

/**
 * @ORM\Entity(repositoryClass=ProjetUserRepository::class)
 */
class ProjetUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Procost\Projet", inversedBy="projetusers")
     * @ORM\JoinColumn (nullable=false,name="projet_id")
     */
    private $projet;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\User", inversedBy="projetusers")
     * @ORM\JoinColumn (nullable=false,name="user_id")
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $cout_ind;

    /**
     * @ORM\Column(type="integer")
     */
    private $temps_ind;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getCoutInd()
    {
        return $this->cout_ind;
    }

    public function setCoutInd($cout_ind): self
    {
        $this->cout_ind = $cout_ind;
        return $this;
    }

    public function getTempsInd()
    {
        return $this->temps_ind;
    }

    public function setTempsInd($temps_ind): self
    {
        $this->temps_ind = $temps_ind;
        return $this;
    }

    public function getProjet()
    {
        return $this->projet;
    }

    public function setProjet($projet): self
    {
        $this->projet = $projet;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;
        return $this;
    }

}