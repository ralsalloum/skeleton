<?php

namespace App\Repository;

use App\Entity\ServicesEntity;
use App\Entity\UserEntity;
use App\Entity\UserProfileEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method UserEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntity[]    findAll()
 * @method UserEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntityRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof UserEntity) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
    
    public function getUserByUserID($userID)
    {
        return $this->createQueryBuilder('user')

            ->select('user.id', 'user.userID')
            ->andWhere('user.userID=:userID')
            ->setParameter('userID', $userID)

            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getUserByEmail($email)
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function getUsersByRole($role)
    {
        return $this->createQueryBuilder('user')
            ->select('user.id', 'user.roles', 'user.userID', 'profile.userName', 'profile.image', 'profile.story', 
            'services.id as serviceID', 'services.serviceTitle', 'services.description', 'services.createdBy', 'services.categoryID', 
            'services.activeUntil', 'services.enabled', 'services.tags')

            ->leftJoin(
                UserProfileEntity::class,
                'profile',
                Join::WITH,
                'profile.userID = user.userID'
            )

            ->leftJoin(
                ServicesEntity::class,
                'services',
                Join::WITH,
                'services.createdBy = user.userID'
            )
            
            ->andWhere('user.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role.'"%')

            ->andWhere("services.enabled = 1")
            ->groupBy('user.id')

            ->getQuery()
            ->getResult();
    }
}
