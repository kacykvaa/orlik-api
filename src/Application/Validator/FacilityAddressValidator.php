<?php

declare(strict_types=1);

namespace App\Application\Validator;

use App\Application\Repository\AddressRepository;
use App\Common\Exception\DuplicateEntityException;

class FacilityAddressValidator
{
    private AddressRepository $repository;

    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    public function AssertAddressDataDoesNotExist(string $street, string $streetNumber, string $postCode)
    {
        $count = $this->repository->countAddressByStreetNumberAndCity($street, $streetNumber, $postCode);

        if ($count !== 0) {
            throw new DuplicateEntityException('Address already exists');
        }
    }
}