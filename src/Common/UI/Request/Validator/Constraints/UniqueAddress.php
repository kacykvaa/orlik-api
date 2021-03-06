<?php

declare(strict_types=1);

namespace App\Common\UI\Request\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueAddress extends Constraint
{
   public string $message = "Facility exists under same address";

    public function validatedBy(): string
    {
        return UniqueAddressValidator::class;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}