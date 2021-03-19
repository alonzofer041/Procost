<?php

namespace App\Controller;

use App\Entity\Procost\Projet;
use App\Repository\Procost\ProjetRepository;
use App\Repository\Procost\ProjetUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    private $em;
    private $projetrepository;
    private $projetuserrepository;

    public function __construct(EntityManagerInterface $em,
                                ProjetRepository $projetRepository,
                                ProjetUserRepository $projetUserRepository)
    {
        $this->em=$em;
        $this->projetrepository=$projetRepository;
        $this->projetuserrepository=$projetUserRepository;
    }

    /**
     * @Route("/projet", name="projet")
     */
    public function index(): Response
    {
        $projets=$this->projetrepository->findAll();
        return $this->render('projet/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    /**
     * @Route("/projet/form/{id?}", name="projet_form")
     */
    public function projetform(Request $request, ?int $id):Response{
        if($id){
            $projet=$this->projetrepository->find($id);
        }
        else{
            $projet=new Projet();
        }
        $form=$this->createForm(\ProjetType::class,$projet);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($projet);
            $this->em->flush();
//            $this->addFlash('success','Merci, votre message a été pris en compte!');
            return $this->redirectToRoute('projet');
        }
        return $this->render('projet/form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/projet/detail/{id}", name="projet_detail")
     */
    public function projetdetail(int $id){
        $projettotal=0;
        $projetusers=$this->projetuserrepository->countEmployeursEnProjet($id);
        $projet=$this->projetrepository->find($id);
        $projetsdet=$this->projetuserrepository->findByProjet($id);
        for($i=0;$i<count($projetsdet);$i++){
            $couttotalind=$projetsdet[$i]->getCoutInd()*$projetsdet[$i]->getTempsInd();
            $projettotal+=$couttotalind;
        }
        return $this->render('projet/detail.html.twig',[
            'projet'=>$projet,
            'projetsdet'=>$projetsdet,
            'projettotal'=>$projettotal,
            'projetusers'=>$projetusers
        ]);
    }

    /**
     * @Route("/projet/livre/{id}", name="projet_livre")
     */
    public function livrer(int $id):RedirectResponse{
        $projet=$this->projetrepository->find($id);
        $projet->setDateLivraison(new \DateTime());
        $this->em->persist($projet);
        $this->em->flush();
        return $this->redirectToRoute('projet');
    }
}
