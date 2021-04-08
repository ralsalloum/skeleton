<?php


namespace App\Response;

class ServiceGetByIdResponse
{
    public $id;
    
    public $serviceTitle;

    public $description;

    public $duration;

    public $categoryID;

    public $createdBy;

    public $activeUntil;

    public $enabled;

    public $tags = [];
}