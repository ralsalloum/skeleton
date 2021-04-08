<?php


namespace App\Request;


class ServiceCreateRequest
{
    private $serviceTitle;

    private $description;

    private $duration;

    private $createdBy;

    private $categoryID;

    private $activeUntil;

    private $enabled;

    private $tags = [];

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

}