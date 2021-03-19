<?php

namespace App\Controller;

use App\Repository\Procost\ProjetRepository;
use App\Repository\Procost\ProjetUserRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $projetrepository;
    private $userrepository;
    private $projetuserrepository;


    public function __construct(ProjetRepository $projetRepository,
                                ProjetUserRepository $projetUserRepository,
                                UserRepository $userRepository){
        $this->projetrepository=$projetRepository;
        $this->projetuserrepository=$projetUserRepository;
        $this->userrepository=$userRepository;
    }
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        $projetsencours=$this->projetrepository->projetEnCours();
        $projetslivres=$this->projetrepository->projetsLivres();
        $nombreemployes=$this->userrepository->nombreEmployeurs();
        $heuresproduction=$this->projetuserrepository->heuresProduction();
        $projetrentable=0;
        $tauxlivraison=100*($projetsencours/$projetslivres);
        $topemploye=$this->projetuserrepository->topEmploye();
        $derniesprojets=$this->projetrepository->dernierProjetsCrees();
        $derniessaisies=$this->projetuserrepository->dernierSaissies();
        return $this->render('main/index.html.twig', [
            'projetsencours' => $projetsencours,
            'projetslivres'=>$projetslivres,
            'nombreemployes'=>$nombreemployes,
            'heuresproduction'=>$heuresproduction,
            'projetrentable'=>$projetrentable,
            'tauxlivraison'=>$tauxlivraison,
            'topemploye'=>$topemploye,
            'derniesprojets'=>$derniesprojets,
            'derniessaisies'=>$derniessaisies
        ]);
    }
}
