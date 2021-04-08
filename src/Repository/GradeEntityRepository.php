<?php

namespace App\Repository;

use App\Entity\GradeEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GradeEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method GradeEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method GradeEntity[]    findAll()
 * @method GradeEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradeEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GradeEntity::class);
    }

    // /**
    //  * @return GradeEntity[] Returns an array of GradeEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GradeEntity
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
