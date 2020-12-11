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
    private  $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="array")
     */
    private  $pitchTypes;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="facility", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="facility", cascade={"persist"})
     */
    private $images;


    public function __construct(string $name, $pitchTypes,  $address)
    {
        $this->name = $name;
        $this->pitchTypes = $pitchTypes;
        $this->address = $address;
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


}
