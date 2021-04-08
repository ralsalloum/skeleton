<?php

namespace App\Repository;

use App\Entity\RatingEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RatingEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method RatingEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method RatingEntity[]    findAll()
 * @method RatingEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RatingEntity::class);
    }

    // /**
    //  * @return RatingEntity[] Returns an array of RatingEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RatingEntity
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
