<?php


namespace App\Entity;

use App\Repository\CatsRepository;
use App\Enum\Gender;
use Doctrine\ORM\Mapping as ORM;

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
    private ?string $gender = null; // Stocke la valeur sous forme de chaîne

    #[ORM\ManyToOne(inversedBy: 'cats')]
    private ?Users $user = null;

    // Getter et Setter pour `gender`
    public function getGender(): ?Gender
    {
        return Gender::from($this->gender);; // Convertir la chaîne en énumération Gender
    }

    public function setGender(Gender $gender): static
    {
        $this->gender = $gender->value; // Enregistrer la valeur de l'énum comme une chaîne
        return $this;
    }

    // Getter et Setter pour `name`
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    // Getter et Setter pour `age`
    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;
        return $this;
    }

    // Getter et Setter pour `breed`
    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(?string $breed): static
    {
        $this->breed = $breed;
        return $this;
    }

    // Getter et Setter pour `user`
    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;
        return $this;
    }
}
