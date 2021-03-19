<?php

namespace App\Entity;

use App\Entity\Procost\ProjetUser;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection as Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;



    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $cout_horaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_embauche;
    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Procost\Metier", inversedBy="users")
     * @ORM\JoinColumn (nullable=false,name="metier_id")
     */
    private $metier;
    /**
     * @ORM\OneToMany (targetEntity="App\Entity\Procost\ProjetUser", mappedBy="user")
     */
    private $projetusers;

    public function __construct()
    {
        $this->projetusers=new Collection();
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
    public function getUsername(): string
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getCoutHoraire(): ?float
    {
        return $this->cout_horaire;
    }

    public function setCoutHoraire(float $cout_horaire): self
    {
        $this->cout_horaire = $cout_horaire;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->date_embauche;
    }

    public function setDateEmbauche(\DateTimeInterface $date_embauche): self
    {
        $this->date_embauche = $date_embauche;

        return $this;
    }

    public function getMetier()
    {
        return $this->metier;
    }

    public function setMetier($metier): void
    {
        $this->metier = $metier;
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
            $projetUser->setUser($this);
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
