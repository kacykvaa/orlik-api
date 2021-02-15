<?php

declare(strict_types=1);

namespace App\UI\Model\Response\Factory;

use App\Application\Entity\Facility as FacilityEntity;
use App\UI\Model\Response\FacilityPitchType;

class FacilityPitchTypeViewModelFactory
{
    private FacilityViewModelFactory $facilityViewModelFactory;
    private PitchTypeViewModelFactory $pitchTypeViewModelFactory;

    public function __construct(
        FacilityViewModelFactory $facilityViewModelFactory,
        PitchTypeViewModelFactory $pitchTypeViewModelFactory
    )
    {
        $this->facilityViewModelFactory = $facilityViewModelFactory;
        $this->pitchTypeViewModelFactory = $pitchTypeViewModelFactory;
    }

    public function create(FacilityEntity $facilityEntity): FacilityPitchType
    {
        $pitchType = $facilityEntity->pitchTypes();
        $facilityViewModel = $this->facilityViewModelFactory->create($facilityEntity);
        $pitchTypeViewModel = [];

        foreach ($pitchType as $value ) {
            $pitchTypeViewModel[] = $this->pitchTypeViewModelFactory->create($value);
        }

        return new FacilityPitchType(
            $facilityViewModel,
            $pitchTypeViewModel
        );
    }
}