<?php

namespace App\Entity;

use App\Repository\CatsRepository;
use App\Enum\Gender;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Conquete;
use App\Entity\Caractere;
use App\Entity\Users;

#[ORM\Entity(repositoryClass: CatsRepository::class)]
class Cats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $breed = null;

    #[ORM\Column(type: "string")]
    private ?string $gender = null;

    #[ORM\ManyToOne(inversedBy: 'cats')]
    private ?Users $user = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $imageId = null;

    #[ORM\ManyToMany(targetEntity: Caractere::class, inversedBy: 'cats')]
    private Collection $caracteres;

    #[ORM\ManyToMany(targetEntity: Conquete::class, inversedBy: 'matchedCats')]
    #[ORM\JoinTable(name: 'cats_conquetes')]
    private Collection $conquetes;

    public function __construct()
    {
        $this->caracteres = new ArrayCollection();
        $this->conquetes  = new ArrayCollection();
    }

    // -------------------- ID --------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    // -------------------- NAME --------------------

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    // -------------------- AGE --------------------

    public function getAge(): ?int
    {
        return $this->age;
    }
    public function setAge(int $age): static
    {
        $this->age = $age;
        return $this;
    }

    // -------------------- BREED --------------------

    public function getBreed(): ?string
    {
        return $this->breed;
    }
    public function setBreed(?string $breed): static
    {
        $this->breed = $breed;
        return $this;
    }

    // -------------------- GENDER --------------------

    public function getGender(): ?Gender
    {
        return $this->gender ? Gender::from($this->gender) : null;
    }
    public function setGender(Gender $gender): static
    {
        $this->gender = $gender->value;
        return $this;
    }

    // -------------------- USER --------------------

    public function getUser(): ?Users
    {
        return $this->user;
    }
    public function setUser(?Users $user): static
    {
        $this->user = $user;
        return $this;
    }

    // -------------------- DESCRIPTION --------------------

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    // -------------------- IMAGE ID --------------------

    public function getImageId(): ?int
    {
        return $this->imageId;
    }
    public function setImageId(?int $imageId): static
    {
        $this->imageId = $imageId;
        return $this;
    }

    // -------------------- CARACTÈRES --------------------

    /**
     * @return Collection<int, Caractere>
     */
    public function getCaracteres(): Collection
    {
        return $this->caracteres;
    }

    public function addCaractere(Caractere $caractere): static
    {
        if (!$this->caracteres->contains($caractere)) {
            $this->caracteres->add($caractere);
        }
        return $this;
    }

    public function removeCaractere(Caractere $caractere): static
    {
        $this->caracteres->removeElement($caractere);
        return $this;
    }

    // -------------------- CONQUÊTES (MATCHES) --------------------

    /**
     * @return Collection<int, Conquete>
     */
    public function getConquetes(): Collection
    {
        return $this->conquetes;
    }

    public function addConquete(Conquete $conquete): static
    {
        if (!$this->conquetes->contains($conquete)) {
            $this->conquetes->add($conquete);
        }
        return $this;
    }

    public function removeConquete(Conquete $conquete): static
    {
        $this->conquetes->removeElement($conquete);
        return $this;
    }
}
