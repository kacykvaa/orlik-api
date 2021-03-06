<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Application\Repository\FacilityRepository;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\FacilityRepository", repositoryClass=FacilityRepository::class)
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
    private Collection $images;

    /**
     * @ORM\Column(type="carbon_immutable")
     */
    private CarbonImmutable $createdAt;

    /**
     * @ORM\Column (type="boolean")
     */
    private bool $deleted = false;

    /**
     * @ORM\Column (type="carbon_immutable", nullable=true)
     */
    private CarbonImmutable $deletedAt;

    public function __construct(string $name, array $pitchTypes)
    {
        $this->name = $name;
        $this->pitchTypes = $pitchTypes;
        $this->images = new ArrayCollection();
        $this->createdAt = new CarbonImmutable();
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

    public function address(): Address
    {
        if (!$this->address) {
            throw new LogicException('Facility must have address');
        }

        return $this->address;
    }

    /**
     * @return Collection|Image[]
     */
    public function image(): Collection
    {
        return $this->images;
    }

    public function createdAt(): CarbonImmutable
    {
        return $this->createdAt;
    }

    public function delete(): void
    {
        $this->deleted = true;
        $this->deletedAt = new CarbonImmutable();
    }

    public function updateAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
    }

    public function updatePitchTypes(array $pitchTypes): void
    {
        $this->pitchTypes = $pitchTypes;
    }
}