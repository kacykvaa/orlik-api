<?php

declare(strict_types=1);

namespace App\Application\Validator;

use App\Application\Repository\FacilityRepository;
use App\Common\Exception\DuplicateEntityException;

class FacilityValidator
{
    private FacilityRepository $facilityRepository;

    public function __construct(FacilityRepository $facilityRepository)
    {
        $this->facilityRepository = $facilityRepository;
    }

    public function assertFacilityDoesNotExist(string $name, string $street, string $streetNumber, string $postCode)
    {
        $count = $this->facilityRepository->countFacilityByNameAndAddress($name, $street, $streetNumber, $postCode);

        if ($count !== 0) {
            throw new DuplicateEntityException('Facility already exists');
        }
    }
}