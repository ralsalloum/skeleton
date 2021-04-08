<?php


namespace App\Service;


use App\AutoMapping;
use App\Entity\ServicesEntity;
use App\Manager\ServicesManager;
use App\Request\ServiceCreateRequest;
use App\Request\ServiceUpdateRequest;
use App\Response\ServiceCreateResponse;
use App\Response\ServiceGetByIdResponse;
use App\Response\ServicesGetResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ServicesService
{
    private $autoMapping;
    private $servicesManager;
    private $params;

    public function __construct(AutoMapping $autoMapping, ServicesManager $servicesManager, ParameterBagInterface $params)
    {
        $this->autoMapping = $autoMapping;
        $this->servicesManager = $servicesManager;
        
        $this->params = $params->get('upload_base_url').'/';
    }

    public function create(ServiceCreateRequest $request)
    {
        $serviceRegister = $this->servicesManager->create($request);

        return $this->autoMapping->map(ServicesEntity::class, ServiceCreateResponse::class, $serviceRegister);
    }

    public function update(ServiceUpdateRequest $request)
    {
        $serviceResult = $this->servicesManager->update($request);

        return $this->autoMapping->map(ServicesEntity::class, ServiceCreateResponse::class, $serviceResult);
    }

    public function delete($request)
    {
        $serviceResult = $this->servicesManager->delete($request);

        if($serviceResult == null)
        {
            return null;
        }

        return $this->autoMapping->map(ServicesEntity::class, ServiceGetByIdResponse::class, $serviceResult);
    }

    public function getServicesByCategoryID($categoryID)
    {
        $servicesResponse = [];

        $results = $this->servicesManager->getServicesByCategoryID($categoryID);

        foreach($results as $result)
        {
            $result['userImage'] = $this->params . $result['userImage'];

            $servicesResponse[] = $this->autoMapping->map('array', ServicesGetResponse::class, $result);
        }

        return $servicesResponse;
    }

    public function getServicesOfUser($userID)
    {
        $servicesResponse = [];

        $results = $this->servicesManager->getServicesOfUser($userID);

        foreach($results as $result)
        {
            $servicesResponse[] = $this->autoMapping->map('array', ServicesGetResponse::class, $result);
        }

        return $servicesResponse;
    }

    public function getServicesBySpecificAccount($serviceID)
    {
        $servicesResponse = [];

        $results = $this->servicesManager->getServicesBySpecificAccount($serviceID);

        foreach($results as $result)
        {
            $result['userImage'] = $this->params . $result['userImage'];

            $servicesResponse[] = $this->autoMapping->map('array', ServicesGetResponse::class, $result);
        }

        return $servicesResponse;
    }
}