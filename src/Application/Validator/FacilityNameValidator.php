<?php

declare(strict_types=1);

namespace App\Application\Validator;

use App\Application\Repository\FacilityRepository;
use App\Common\Exception\DuplicateEntityException;

class FacilityNameValidator
{
    private FacilityRepository $repository;

    public function __construct(FacilityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function assertFacilityNameDoesNotExist(string $name)
    {
        $count = $this->repository->countFacilityByName($name);

        if ($count !== 0) {
            throw new DuplicateEntityException('Facility with that name already exists');
        }
    }
}