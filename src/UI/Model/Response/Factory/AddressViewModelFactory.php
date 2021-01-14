<?php

declare(strict_types=1);

namespace App\UI\Model\Response\Factory;

use App\Application\Entity\Address as AddressEntity;
use App\UI\Model\Response\Address;

class AddressViewModelFactory
{
    public function create(AddressEntity $address): Address
    {
        return new Address(
            $address->id(),
            $address->street(),
            $address->streetNumber(),
            $address->city(),
            $address->postCode(),
        );
    }
}