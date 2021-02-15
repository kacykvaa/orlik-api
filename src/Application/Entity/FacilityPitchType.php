<?php

declare(strict_types=1);

namespace App\Application\Entity;

use App\Common\Doctrine\GeneratedIdColumn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="faciility_pitch_type")
 */
class FacilityPitchType
{
    use GeneratedIdColumn;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $available;

    /**
     * @ORM\ManyToOne (targetEntity="App\Application\Entity\Facility", inversedBy="facilityPitchTypes")
     * @ORM\JoinColumn(name="facility_id", referencedColumnName="id", nullable=false)
     */
    private Facility $facility;

    /**
     * @ORM\ManyToOne (targetEntity="App\Application\Entity\PitchType")
     * @ORM\JoinColumn(name="pitch_type_id", referencedColumnName="id", nullable=false)
     */
    private PitchType $pitchType;

    public function __construct(bool $available, Facility $facility, PitchType $pitchType)
    {
        $this->available = $available;
        $this->facility = $facility;
        $this->pitchType = $pitchType;
    }

    public function available(): bool
    {
        return $this->available;
    }

    public function facility(): Facility
    {
        return $this->facility;
    }

    public function pitchType(): PitchType
    {
        return $this->pitchType;
    }

    public function makeAvailable(): void
    {
        $this->available = true;
    }

    public function makeUnAvailable()
    {
        $this->available = false;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }
}