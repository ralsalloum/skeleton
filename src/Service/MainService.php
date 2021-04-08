<?php


namespace App\Service;


use App\AutoMapping;
use App\Manager\MainManager;
use App\Request\FilterRequest;
use App\Response\GetHistoryResponse;
use App\Response\GetStatisticsResponse;
use App\Response\MembersGetResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MainService
{
    private $autoMapping;
    private $mainManager;
    private $userService;
    private $params;

    public function __construct(AutoMapping $autoMapping, MainManager $mainManager, ParameterBagInterface $params,
     UserService $userService)
    {
        $this->autoMapping = $autoMapping;
        $this->mainManager = $mainManager;
        $this->userService = $userService;

        $this->params = $params->get('upload_base_url').'/';
    }

    public function getAllMembers()
    {
        $response = [];

        $response['personal'] = $this->userService->getUsersByRole("user");

        $response['company'] = $this->userService->getUsersByRole("company");

        return $response;
    }
}