<?php

namespace App\Repository;

use App\Entity\ResetPasswordRequestEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResetPasswordRequestEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResetPasswordRequestEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResetPasswordRequestEntity[]    findAll()
 * @method ResetPasswordRequestEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResetPasswordRequestEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequestEntity::class);
    }

    public function getResetPasswordRequestByEmailAndCode($email, $code)
    {
        return $this->createQueryBuilder('reset_password_request')

            ->andWhere('reset_password_request.email = :email')
            ->andWhere('reset_password_request.code = :code')

            ->setParameter('email', $email)
            ->setParameter('code', $code)
            
            ->getQuery()
            ->getOneOrNullResult();
    }
}
