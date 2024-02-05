<?php

namespace App\Entity;

use App\Repository\ApartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ApartmentRepository::class)]
class Apartment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['apartment'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Field 'number' should not be blank")]
    #[Assert\Type(type: "integer", message: "Field 'number' should be integer")]
    #[Groups(['apartment'])]
    private ?int $number = null;

    #[ORM\ManyToOne(inversedBy: 'apartments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['apartment'])]
    private ?House $house = null;

    #[ORM\OneToMany(targetEntity: Person::class, mappedBy: 'apartment', orphanRemoval: true)]
    #[Groups(['apartment'])]
    private Collection $people;

    public function __construct()
    {
        $this->people = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setHouse(?House $house): static
    {
        $this->house = $house;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getPeople(): Collection
    {
        return $this->people;
    }

    public function addPerson(Person $person): static
    {
        if (!$this->people->contains($person)) {
            $this->people->add($person);
            $person->setApartment($this);
        }

        return $this;
    }

    public function removePerson(Person $person): static
    {
        if ($this->people->removeElement($person)) {
            // set the owning side to null (unless already changed)
            if ($person->getApartment() === $this) {
                $person->setApartment(null);
            }
        }

        return $this;
    }

    #[Assert\NotBlank(message: "Field 'house_id' should not be blank")]
    #[Assert\Type("integer",  message: "Field 'house_id' should be integer")]
    public ?int $house_id;
}
