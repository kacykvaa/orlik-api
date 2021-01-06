<?php

declare(strict_types=1);


namespace App\UI\Model\Response\Factory;


use App\Application\Entity\Facility as FacilityEntity;
use App\UI\Model\Response\Facility;

class FacilityViewModelFactory
{
    private AddressViewModelFactory $addressViewModelFactory;

    public function __construct(AddressViewModelFactory $addressViewModelFactory)
    {
        $this->addressViewModelFactory = $addressViewModelFactory;
    }

    public function create(FacilityEntity $facility): Facility
    {
        $address = $facility->address();
        $addressViewModel = $this->addressViewModelFactory->create($address);

        return new Facility(
            $facility->id(),
            $facility->name(),
            $facility->pitchTypes(),
            $addressViewModel,
            $facility->createdAt(),
        );
    }
}