<?php

declare(strict_types=1);

namespace App\UI\Model\Response\Factory;

use App\Application\Entity\FacilityPitchType;
use App\UI\Model\Response\PitchType;

class PitchTypeViewModelFactory
{
    public function create(FacilityPitchType $pitchType): PitchType
    {
        return new PitchType(
            $pitchType->id(),
            $pitchType->pitchType()->name()
        );
    }
}