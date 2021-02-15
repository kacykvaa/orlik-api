<?php

declare(strict_types=1);

namespace App\UI\Model\Response;

class FacilityPitchType
{
    public Facility $facility;
    public array $pitchType;

    public function __construct(Facility $facility, array $pitchType)
    {
        $this->facility = $facility;
        $this->pitchType = $pitchType;
    }
}