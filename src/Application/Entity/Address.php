<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Application\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
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
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private string $postCode;

    /**
     * @ORM\OneToOne(targetEntity=Facility::class, mappedBy="facility")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id")
     */
    private Facility $facility;

    /**
     * @return mixed
     */
    public function facility(): Facility
    {
        return $this->facility;
    }

    public function __construct(string $street, string $streetNumber, string $city, string $postCode, Facility $facility)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->postCode = $postCode;
        $this->facility = $facility;
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

    public function updateData(string $street, string $streetNumber, string $city, string $postCode)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->postCode = $postCode;
    }
}