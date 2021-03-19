<?php

namespace App\Repository\Procost;

use App\Entity\Procost\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    // /**
    //  * @return Projet[] Returns an array of Projet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function projetEnCours():int{
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->where('p.date_livraison is null')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function projetsLivres():int{
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->where('p.date_livraison is not null')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function dernierProjetsCrees(){
        return $this->addEmploye($this->createQueryBuilder('p'))
            ->select('p.nom','p.created_At','p.prix','sum(pu.temps_ind*pu.cout_ind) as total','p.date_livraison')
            ->groupBy('p')
            ->orderBy('p.created_At')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
    public function projetRentable(){

    }
    private function addEmploye(QueryBuilder $qb,string $alias='p'): QueryBuilder{
        $qb->addSelect('pu')
            ->leftJoin($alias.'.projetusers','pu');
        return $qb;
    }
}
