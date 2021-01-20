<?php

declare(strict_types=1);

namespace App\Common\UI\Request\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueFacilityName extends Constraint
{
    public string $message = "{{ string }} already exists!";

    public function validatedBy(): string
    {
        return get_class($this) . 'Validator';
    }
}