<?php


namespace App\Manager;


use App\AutoMapping;
use App\Entity\UserEntity;
use App\Entity\UserProfileEntity;
use App\Repository\UserEntityRepository;
use App\Repository\UserProfileEntityRepository;
use App\Request\UserProfileCreateRequest;
use App\Request\UserProfileUpdateRequest;
use App\Request\UserRegisterRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $autoMapping;
    private $entityManager;
    private $encoder;
    private $userRepository;
    private $userProfileEntityRepository;

    public function __construct(AutoMapping $autoMapping, EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $encoder, UserEntityRepository $userRepository, UserProfileEntityRepository $userProfileEntityRepository)
    {
        $this->autoMapping = $autoMapping;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
        $this->userProfileEntityRepository = $userProfileEntityRepository;
    }

    public function userRegister(UserRegisterRequest $request)
    {
        // First, create the user

        $userResult = $this->getUserByUserID($request->getUserID());

        if ($userResult == null) 
        {
            $userRegister = $this->autoMapping->map(UserRegisterRequest::class, UserEntity::class, $request);

            $user = new UserEntity($request->getUserID());

            if ($request->getPassword())
            {
                $userRegister->setPassword($this->encoder->encodePassword($user, $request->getPassword()));
            }

            if ($request->getRoles() == null)
            {
                $request->setRoles(['user']);
            }

            $userRegister->setRoles($request->getRoles());

            $this->entityManager->persist($userRegister);
            $this->entityManager->flush();
            $this->entityManager->clear();

            // Second, create the user's profile

            $userProfile = $this->getProfileByUserID($request->getUserID());

            if ($userProfile == null) 
            {
                $userProfile = $this->autoMapping->map(UserRegisterRequest::class, UserProfileEntity::class, $request);

                $this->entityManager->persist($userProfile);
                $this->entityManager->flush();
                $this->entityManager->clear();
            }

            return $userRegister;

        }
        else
        {
            $userProfile = $this->getProfileByUserID($request->getUserID());

            if ($userProfile == null) 
            {
                $userProfile = $this->autoMapping->map(UserRegisterRequest::class, UserProfileEntity::class, $request);

                $this->entityManager->persist($userProfile);
                $this->entityManager->flush();
                $this->entityManager->clear();
            }

            return true;
        }
        

    }

    // public function userProfileCreate(UserProfileCreateRequest $request)
    // {
    //    $userProfile = $this->getProfileByUserID($request->getUserID());
    //    if ($userProfile == null) {
    //         $userProfile = $this->autoMapping->map(UserProfileCreateRequest::class, UserProfileEntity::class, $request);

    //         $this->entityManager->persist($userProfile);
    //         $this->entityManager->flush();
    //         $this->entityManager->clear();

    //         return $userProfile;
    // }
    //     else {
    //         return true;
    //    }
    // }

    public function userProfileUpdate(UserProfileUpdateRequest $request)
    {
        $item = $this->userProfileEntityRepository->getUserProfile($request->getUserID());

        if ($item)
        {
            $item = $this->autoMapping->mapToObject(UserProfileUpdateRequest::class,
                UserProfileEntity::class, $request, $item);

            $this->entityManager->flush();
            $this->entityManager->clear();

            return $item;
        }
    }

    public function getProfileByUserID($userID)
    {
        return $this->userProfileEntityRepository->getProfileByUSerID($userID);
    }

    public function getUserByUserID($userID)
    {
        return $this->userRepository->getUserByUserID($userID);
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function getUsersByRole($role)
    {
        return $this->userRepository->getUsersByRole($role);
    }
}