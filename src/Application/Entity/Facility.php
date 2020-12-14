<?php

namespace App\Application\Entity;

use App\Application\Repository\FacilityRepository;
use Carbon\Carbon;
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

    /**
     * @ORM\Column(type="datetime")
     */
    private Carbon $createdAt;

    public function __construct(string $name, array $pitchTypes)
    {
        $this->name = $name;
        $this->pitchTypes = $pitchTypes;
        $this->images = new ArrayCollection();
        $this->createdAt = Carbon::now();
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

   public function createdAt(): string
   {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    public function updateAddress(Address $address): void
    {
        $this->address = $address;
    }
}