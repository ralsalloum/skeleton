<?php

namespace App\Entity;

use App\Repository\FavouriteEntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavouriteEntityRepository::class)
 */
class FavouriteEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userID;

    /**
     * @ORM\Column(type="integer")
     */
    private $categoryID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserID(): ?string
    {
        return $this->userID;
    }

    public function setUserID(string $userID): self
    {
        $this->userID = $userID;

        return $this;
    }

    public function getCategoryID(): ?int
    {
        return $this->categoryID;
    }

    public function setCategoryID(int $categoryID): self
    {
        $this->categoryID = $categoryID;

        return $this;
    }
}
