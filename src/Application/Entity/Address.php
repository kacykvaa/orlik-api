<?php

namespace App\Application\Entity;

use App\Application\Repository\AdressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdressRepository::class)
 */
class Address
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
    private string $street;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private string $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotNull
     */
    private string $postCode;

    /**
     * @ORM\OneToOne(targetEntity=Facility::class, mappedBy="facility", cascade={"persist"})
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")

     */
    private $facility;

    /**
     * @return mixed
     */
    public function facility()
    {
        return $this->facility;
    }

    public function __construct(string $street, string $streetNumber, string $city, string $postCode)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->postCode = $postCode;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function street(): ?string
    {
        return $this->street;
    }

    public function streetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function city(): ?string
    {
        return $this->city;
    }

    public function postCode(): ?string
    {
        return $this->postCode;
    }
}
