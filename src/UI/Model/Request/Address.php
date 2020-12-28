<?php


namespace App\UI\Model\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Address
{
    /**
     * @Assert\NotNull()
     */
    public  $street;
    /**
     * @Assert\NotNull()
     */
    public  $streetNumber;
    /**
     * @Assert\NotNull()
     */
    public  $city;
    /**
     * @Assert\NotNull()
     */
    public  $postCode;
}