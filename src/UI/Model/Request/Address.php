<?php


namespace App\UI\Model\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Address
{
    /**
     * @Assert\NotNull()
     */
    public string $street;
    /**
     * @Assert\NotNull()
     */
    public string $streetNumber;
    /**
     * @Assert\NotNull()
     */
    public string $city;
    /**
     * @Assert\NotNull()
     */
    public string $postCode;
}