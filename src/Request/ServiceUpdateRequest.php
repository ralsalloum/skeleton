<?php


namespace App\Request;


class ServiceUpdateRequest
{
    private $id;

    private $serviceTitle;

    private $description;

    private $duration;

    private $categoryID;

    private $activeUntil;

    private $enabled;

    private $tags = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

}