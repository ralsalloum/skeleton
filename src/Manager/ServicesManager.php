<?php


namespace App\Manager;


use App\AutoMapping;
use App\Entity\ServicesEntity;
use App\Repository\ServicesEntityRepository;
use App\Request\DeleteRequest;
use App\Request\ServiceCreateRequest;
use App\Request\ServiceUpdateRequest;
use Doctrine\ORM\EntityManagerInterface;

class ServicesManager
{
    private $autoMapping;
    private $entityManager;
    private $servicesEntityRepository;

    public function __construct(AutoMapping $autoMapping, EntityManagerInterface $entityManager, ServicesEntityRepository $servicesEntityRepository)
    {
        $this->autoMapping = $autoMapping;
        $this->entityManager = $entityManager;
        $this->servicesEntityRepository = $servicesEntityRepository;
    }

    public function create(ServiceCreateRequest $request)
    {
        $serviceEntity = $this->autoMapping->map(ServiceCreateRequest::class, ServicesEntity::class, $request);

        $serviceEntity->setDuration($request->getDuration());
        $serviceEntity->setActiveUntil($serviceEntity->getActiveUntil());

        $this->entityManager->persist($serviceEntity);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $serviceEntity;
    }

    public function update(ServiceUpdateRequest $request)
    {
        $serviceEntity = $this->servicesEntityRepository->find($request->getId());

        if(!$serviceEntity)
        {

        }
        else
        {
            $serviceEntity = $this->autoMapping->mapToObject(ServiceUpdateRequest::class, ServicesEntity::class,
                $request, $serviceEntity);

            $serviceEntity->setDuration($request->getDuration());
            $serviceEntity->setActiveUntil($serviceEntity->getActiveUntil());

            $this->entityManager->flush();

            return $serviceEntity;
        }
    }

    public function delete(DeleteRequest $request)
    {
        $service = $this->servicesEntityRepository->find($request->getId());

        if(!$service)
        {
            return null;
        }
        else
        {
            $this->entityManager->remove($service);
            $this->entityManager->flush();
        }

        return $service;
    }

    public function getServicesByCategoryID($categoryID)
    {
        return $this->servicesEntityRepository->getServicesByCategoryID($categoryID);
    }
    
    public function getServicesOfUser($userID)
    {
        return $this->servicesEntityRepository->getServicesOfUser($userID);
    }

    public function getServicesBySpecificAccount($serviceID)
    {
        return $this->servicesEntityRepository->getServicesBySpecificAccount($serviceID);
    }

}