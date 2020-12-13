<?php

namespace App\Application\Entity;

use App\Application\Repository\FacilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacilityRepository::class)
 */
class Facility
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="array")
     */
    private array $pitchTypes;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="facility", cascade={"persist", "remove"})
     */
    private Address $address;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="facility", cascade={"persist"})
     */
    private $images;

    public function __construct(string $name, array $pitchTypes)
    {
        $this->name = $name;
        $this->pitchTypes = $pitchTypes;
        $this->images = new ArrayCollection();
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function pitchTypes(): ?array
    {
        return $this->pitchTypes;
    }

    public function address(): ?Address
    {
        return $this->address;
    }

    /**
     * @return Collection|Image[]
     */
    public function image(): Collection
    {
        return $this->images;
    }

    public function updateAddress(Address $address): void
    {
        $this->address = $address;
    }
}