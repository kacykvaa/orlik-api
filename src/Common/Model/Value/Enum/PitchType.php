<?php

declare(strict_types=1);

namespace App\Common\Model\Value\Enum;

use MyCLabs\Enum\Enum;

class PitchType extends Enum
{
    public const FOOTBALL = 'FOOTBALL';
    public const BASKETBALL = 'BASKETBALL';
    public const TENNIS = 'TENNIS';

    public static function FOOTBALL(): PitchType
    {
        return new self(self::FOOTBALL);
    }

    public static function BASKETBALL(): PitchType
    {
        return new self(self::BASKETBALL);
    }

    public static function TENNIS(): PitchType
    {
        return new self(self::TENNIS);
    }

    public function isBasketBallOrFootball(): bool
    {
        return $this->equals(PitchType::FOOTBALL()) || $this->equals(PitchType::BASKETBALL());
    }
}