<?php

namespace App\UI\Model\Response;

class Address
{
    public string $street;

    public string $streetNumber;

    public string $city;

    public string $postCode;

    public function __construct(string $street, string $streetNumber, string $city, string $postCode)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->postCode = $postCode;
    }
}