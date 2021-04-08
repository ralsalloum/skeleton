<?php


namespace App\Request;


class CategoryUpdateRequest
{
    private $id;

    private $name;

    private $description;

    public function getId()
    {
        return $this->id;
    }
}