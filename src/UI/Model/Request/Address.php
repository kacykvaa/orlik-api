<?php

declare(strict_types=1);

namespace App\UI\Model\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Common\UI\Request\Validator\Constraints as AcmeAssert;

/**
 * @AcmeAssert\UniqueAddress()
 */
class Address
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    public  $street;
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public $streetNumber;
    /**
     * @Assert\NotBlank
     * @Assert\NotNull()
     */
    public $city;
    /**
     * @Assert\NotBlank
     * @Assert\NotNull()
     */
    public $postCode;
}