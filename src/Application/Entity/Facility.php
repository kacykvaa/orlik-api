<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Application\Repository\FacilityRepository;
use App\Common\Doctrine\GeneratedIdColumn;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\FacilityRepository", repositoryClass=FacilityRepository::class)
 */
class Facility
{
    use GeneratedIdColumn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

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

    /**
     * @ORM\Column (type="string")
     */
    private string $nameToSearch;

    /**
     * @ORM\OneToMany (targetEntity="FacilityPitchType", mappedBy="facility")
     */
    private Collection $facilityPitchTypes;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->images = new ArrayCollection();
        $this->createdAt = new CarbonImmutable();
        $this->nameToSearch = str_replace(' ', '', mb_strtolower($name));
        $this->facilityPitchTypes = new  ArrayCollection();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function address(): Address
    {
        if (!$this->address) {
            throw new LogicException('Facility must have address');
        }
        return $this->address;
    }

    /**
     * @return FacilityPitchType[]
     */
    public function pitchTypes(): array
    {
        $pitchType = [];
        /** @var FacilityPitchType $facilityPitchType */
        foreach ($this->facilityPitchTypes as $facilityPitchType){
            $pitchType[]  = $facilityPitchType;
        }
        return $pitchType;
    }

    /**
     * @return PitchType[]
     */
    public function availablePitchTypes(): array
    {
        $pitchTypes = [];
        /** @var FacilityPitchType $facilityPitchType */
        foreach ($this->facilityPitchTypes as $facilityPitchType) {
            if (!$facilityPitchType->isAvailable()) {
                continue;
            }
            $pitchTypes [] = $facilityPitchType->pitchType();
        }
        return $pitchTypes;
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
        $this->nameToSearch = str_replace(' ', '', mb_strtolower($name));
    }
}