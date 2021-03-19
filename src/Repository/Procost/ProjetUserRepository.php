<?php

namespace App\Repository\Procost;

use App\Entity\Procost\ProjetUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjetUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjetUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjetUser[]    findAll()
 * @method ProjetUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjetUser::class);
    }

    // /**
    //  * @return ProjetUser[] Returns an array of ProjetUser objects
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
    public function findOneBySomeField($value): ?ProjetUser
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByUser($value):array{
        return $this->createQueryBuilder('p')
            ->where('p.user = :val')
            ->setParameter('val',$value)
            ->getQuery()
            ->getResult();
    }
    public function findByProjet($value):array{
        return $this->createQueryBuilder('p')
            ->where('p.projet = :val')
            ->setParameter('val',$value)
            ->getQuery()
            ->getResult();
    }
    public function countEmployeursEnProjet($value):int{
        return $this->createQueryBuilder('p')
            ->select('count(distinct p.user)')
            ->where('p.projet = :val')
            ->setParameter('val',$value)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function heuresProduction():int{
        return $this->createQueryBuilder('p')
            ->select('sum(p.temps_ind)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function topEmploye(){
        return $this->addEmploye($this->createQueryBuilder('p'))
            ->addSelect('sum(p.cout_ind*p.temps_ind) as total','e.prenom','e.nom','e.date_embauche')
            ->groupBy('p')
            ->orderBy('sum(p.cout_ind*p.temps_ind)','DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function dernierSaissies(){
        return $this->addEmploye($this->createQueryBuilder('p'))
            ->AddSelect('pr')
            ->leftJoin('p.projet','pr')
            ->addSelect('e.prenom','e.nom','e.date_embauche','pr.nom as projetnom','p.temps_ind')
            ->groupBy('p')
            ->orderBy('p.id','DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    private function addEmploye(QueryBuilder $qb, string $alias='p'):QueryBuilder{
        $qb->addSelect('e')
            ->leftJoin($alias.'.user','e');
        return $qb;
    }
}
