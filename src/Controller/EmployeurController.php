<?php

namespace App\Controller;

use App\Entity\Procost\ProjetUser;
use App\Entity\User;
use App\Repository\Procost\ProjetRepository;
use App\Repository\Procost\ProjetUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeurController extends AbstractController
{
    private $userrepository;
    private $projetuserrepository;
    private $em;
    private $projetrepository;
    public function __construct(UserRepository $userRepository,
                                ProjetUserRepository $projetUserRepository,
                                ProjetRepository $projetRepository, EntityManagerInterface $em){
        $this->userrepository=$userRepository;
        $this->projetuserrepository=$projetUserRepository;
        $this->projetrepository=$projetRepository;
        $this->em=$em;
    }
    /**
     * @Route("/employeur", name="employeur")
     */
    public function index(): Response
    {
        $users=$this->userrepository->findAll();
        return $this->render('employeur/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/employeur/form/{id?}", name="employeur_form")
     */
    public function employeurform(?int $id,Request $request):Response{
        if($id){
            $user=$this->userrepository->find($id);
        }
        else{
            $user=new User();
        }
        $form=$this->createForm(\EmployeurType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($user);
            $this->em->flush();
//            $this->addFlash('success','Merci, votre message a été pris en compte!');
            return $this->redirectToRoute('employeur');
        }
        return $this->render('employeur/form.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/employeur/detail/{id?}", name="employeur_detail")
     */
    public function detail(int $id, Request $request):Response{
        $projetuser=new ProjetUser();
        $form=$this->createForm(\ProjetUserType::class,$projetuser);
        $user=$this->userrepository->find($id);
        $projets=$this->projetuserrepository->findByUser($id);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $projetid=$form->get('projet');
            $projet=$this->projetrepository->find($projetid);
            $projet->addUser($projetuser);
            $user->addUser($projetuser);
            $this->em->persist($projetuser);
            $this->em->flush();
//            $this->addFlash('success','Merci, votre message a été pris en compte!');
            return $this->redirectToRoute('employeur');
        }
        return $this->render('employeur/detail.html.twig',[
            'user'=>$user,
            'projets'=>$projets,
            'form'=>$form->createView()
        ]);
    }
}
