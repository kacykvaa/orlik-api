<?php

declare(strict_types=1);

namespace App\UI\Model\Response;

class Address
{
    public int $id;
    public string $street;
    public string $streetNumber;
    public string $city;
    public string $postCode;

    public function __construct(int $id, string $street, string $streetNumber, string $city, string $postCode)
    {
        $this->id = $id;
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->postCode = $postCode;
    }
}