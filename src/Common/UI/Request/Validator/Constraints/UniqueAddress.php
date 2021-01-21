<?php

declare(strict_types=1);

namespace App\Common\UI\Request\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueAddress extends Constraint
{
   public string $message = "Address already exists!";

    public function validatedBy(): string
    {
        return get_class($this) . 'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}