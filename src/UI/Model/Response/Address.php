<?php


namespace App\UI\Model\Response;


class Address
{
    public string $street;

    public string $streetNumber;

    public string $city;

    public string $postCode;

    public function __construct($street, $streetNumber, $city, $postCode)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->city = $city;
        $this->postCode = $postCode;
    }
}