<?php


namespace App\Response;


class ServiceCreateResponse
{
    public $serviceTitle;

    public $description;

    public $duration;

    public $categoryID;

    public $activeUntil;

    public $enabled;

    public $tags = [];
}