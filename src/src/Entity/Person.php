<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[Table(name: "person", uniqueConstraints: [new UniqueConstraint(name: "personal_id_number_unique", columns: ["personal_id_number"])])]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['apartment'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Assert\NotBlank(message: "Field 'name' should not be blank")]
    #[Assert\Type(type: "string", message: "Field 'name' should be string")]
    #[Groups(['apartment'])]
    private ?string $name = null;

    #[ORM\Column(length: 128)]
    #[Assert\NotBlank(message: "Field 'last_name' should not be blank")]
    #[Assert\Type(type: "string", message: "Field 'last_name' should be string")]
    #[Groups(['apartment'])]
    private ?string $last_name = null;

    #[ORM\Column(type: "date")]
    #[Assert\NotBlank(message: "Field 'birthdate' should not be blank")]
    #[Groups(['apartment'])]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\ManyToOne(inversedBy: 'people')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Apartment $apartment = null;

    #[ORM\Column(type: 'string', length: 128, unique: true)]
    #[Assert\NotBlank(message: "Field 'personal_id_number' should not be blank")]
    #[Assert\Type(type: "string", message: "Field 'personal_id_number' should be string")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9]+$/",
        message: "The string must contain only letters and numbers."
    )]
    #[Groups(['apartment'])]
    private ?string $personal_id_number = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getApartment(): ?Apartment
    {
        return $this->apartment;
    }

    public function setApartment(?Apartment $apartment): static
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function getPersonalIdNumber(): ?string
    {
        return $this->personal_id_number;
    }

    public function setPersonalIdNumber(string $personal_id_number): static
    {
        $this->personal_id_number = $personal_id_number;

        return $this;
    }
    #[Assert\NotBlank(message: "Field 'apartment_id' should not be blank")]
    #[Assert\Type("integer",  message: "Field 'apartment_id' should be integer")]
    #[Groups(['person'])]
    public ?int $apartment_id;
}
