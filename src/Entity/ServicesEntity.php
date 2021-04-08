<?php

namespace App\Entity;

use App\Repository\ServicesEntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServicesEntityRepository::class)
 */
class ServicesEntity
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
    private $serviceTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="time")
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="integer")
     */
    private $categoryID;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $activeUntil;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\Column(type="json")
     */
    private $tags = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceTitle(): ?string
    {
        return $this->serviceTitle;
    }

    public function setServiceTitle(string $serviceTitle): self
    {
        $this->serviceTitle = $serviceTitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        $this->duration = new \DateTime($duration);

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

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

    public function getActiveUntil()
    {
        return $this->activeUntil;
    }

    public function setActiveUntil($activeUntil): self
    {
        $this->activeUntil = new \DateTime($activeUntil);

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }
}
