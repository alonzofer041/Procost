<?php

namespace App\DataFixtures;

use App\Entity\Procost\Metier;
use App\Entity\Procost\Projet;
use App\Entity\Procost\ProjetUser;
use App\Entity\User;
use App\Repository\Procost\MetierRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var ObjectManager**/
    private $manager;
    private $passwordhash;
    private $userrepository;
    private $metierrepository;
    protected $faker;

    public function __construct(UserPasswordEncoderInterface $passwordhash,
                                MetierRepository $metierRepository,UserRepository $userRepository){
        $this->passwordhash=$passwordhash;
        $this->userrepository=$userRepository;
        $this->metierrepository=$metierRepository;
        $this->faker=Factory::create();
    }
    public function load(ObjectManager $manager):void
    {
        $this->manager=$manager;
        // $product = new Product();
        // $manager->persist($product);
        $this->loadMetiers();
        $this->manager->flush();
        $this->loadUsers();
        $this->manager->flush();
        $this->loadProjet();
        $this->manager->flush();
    }
    public function loadMetiers():void{
        $metiers=["informatique","biologie","tourisme","logistique","industrie"];
        foreach ($metiers as $metiernom){
            $metier=(new Metier())
                ->setNom($metiernom);
            $this->manager->persist($metier);
        }
    }
    public function loadUsers():void{
        $metiers=$this->metierrepository->findAll();
        for ($i=0;$i<20;$i++){
            $index=$this->faker->numberBetween(0,count($metiers)-1);
            $metier=$metiers[$index];
            $user=(new User())
                ->setPrenom($this->faker->firstName)
                ->setNom($this->faker->lastName)
                ->setEmail($this->faker->email)
                ->setCoutHoraire($this->faker->randomNumber(3))
                ->setDateEmbauche($this->faker->dateTimeBetween('-10 years','now'))
                ->setRoles(["ROLE_USER"]);
            $encoded=$this->passwordhash->encodePassword($user,'12345');
            $user->setPassword($encoded);
            $metier->addUser($user);
            $this->manager->persist($user);
        }
    }
    public function loadProjet():void{
        $users=$this->userrepository->findAll();
        for ($i=0;$i<80;$i++){
            $bool=$this->faker->boolean;
            $projet=(new Projet())
                ->setNom($this->faker->city)
                ->setDescription($this->faker->realText(200))
                ->setPrix($this->faker->randomNumber(4));
            if($bool){
                $projet->setDateLivraison($this->faker->dateTimeBetween('-10 years','+4 years'));
            }
            else{
                $projet->setDateLivraison(null);
            }
            $this->manager->persist($projet);
            $numfois=$this->faker->numberBetween(5,15);
            for($j=0;$j<$numfois;$j++){
                $indexuser=$this->faker->numberBetween(0,count($users)-1);
                $user=$users[$indexuser];
                $projetuser=(new ProjetUser())
                    ->setCoutInd($user->getCoutHoraire())
                    ->setTempsInd($this->faker->randomNumber(2));
                $projet->addUser($projetuser);
                $user->addUser($projetuser);
                $this->manager->persist($projetuser);
            }
        }
    }
}
