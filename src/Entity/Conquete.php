<?php

// src/Entity/Conquete.php
namespace App\Entity;

use App\Repository\ConqueteRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\Gender;

#[ORM\Entity(repositoryClass: ConqueteRepository::class)]
class Conquete
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private string $breed;

    #[ORM\Column]
    private int $imageId;

    // **Nouveau** : sexe
    #[ORM\Column(type: "string", length: 10)]
    private string $gender;

    // … getters & setters …

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
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

    public function getBreed(): string
    {
        return $this->breed;
    }
    public function setBreed(string $breed): self
    {
        $this->breed = $breed;
        return $this;
    }

    public function getImageId(): int
    {
        return $this->imageId;
    }
    public function setImageId(int $imageId): self
    {
        $this->imageId = $imageId;
        return $this;
    }

    // getter/setter pour gender
    public function getGender(): string
    {
        return $this->gender;
    }
    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }
}
