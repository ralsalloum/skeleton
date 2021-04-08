<?php

namespace App\Repository;

use App\Entity\FavouriteEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavouriteEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouriteEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouriteEntity[]    findAll()
 * @method FavouriteEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouriteEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouriteEntity::class);
    }

    // /**
    //  * @return FavouriteEntity[] Returns an array of FavouriteEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavouriteEntity
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
