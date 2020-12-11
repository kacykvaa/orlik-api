<?php


namespace App\UI\Model\Request;


use Symfony\Component\Validator\Constraints as Assert;

class Address
{
    public $street;

    public  $streetNumber;
    /**
     * @Assert\NotNull()
     */
    public  $city;

    public  $postCode;

}