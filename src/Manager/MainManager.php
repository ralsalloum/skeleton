<?php


namespace App\Manager;


use App\AutoMapping;
use Doctrine\ORM\EntityManagerInterface;

class MainManager
{
    private $autoMapping;
    private $userManager;

    public function __construct(AutoMapping $autoMapping, UserManager $userManager)
    {
        $this->autoMapping = $autoMapping;
        $this->userManager = $userManager;
    }

}