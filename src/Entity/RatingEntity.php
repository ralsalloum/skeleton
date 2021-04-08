<?php

namespace App\Entity;

use App\Repository\RatingEntityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingEntityRepository::class)
 */
class RatingEntity
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
    private $createdBy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entityID;

    /**
     * @ORM\Column(type="float")
     */
    private $rateValue;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEntityID(): ?string
    {
        return $this->entityID;
    }

    public function setEntityID(string $entityID): self
    {
        $this->entityID = $entityID;

        return $this;
    }

    public function getRateValue(): ?float
    {
        return $this->rateValue;
    }

    public function setRateValue(float $rateValue): self
    {
        $this->rateValue = $rateValue;

        return $this;
    }
}
