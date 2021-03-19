<?php

namespace App\Controller;

use App\Entity\Procost\Metier;
use App\Repository\Procost\MetierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MetierController extends AbstractController
{
    private $metierrepository;
    private $em;
    public function __construct(EntityManagerInterface $entityManager,MetierRepository $metierRepository){
        $this->metierrepository=$metierRepository;
        $this->em=$entityManager;
    }
    /**
     * @Route("/metier", name="metier")
     */
    public function index(): Response
    {
        $metiers=$this->metierrepository->findAll();
        return $this->render('metier/index.html.twig', [
            'metiers' => $metiers,
        ]);
    }
    /**
     * @Route("/metier/form/{id?}", name="metier_form")
     */
    public function metierform(?int $id, Request $request){
        if($id){
            $metier=$this->metierrepository->find($id);
        }
        else{
            $metier=new Metier();
        }
        $form=$this->createForm(\MetierType::class,$metier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($metier);
            $this->em->flush();
//            $this->addFlash('success','Merci, votre message a été pris en compte!');
            return $this->redirectToRoute('metier');
        }
        return $this->render('metier/form.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
