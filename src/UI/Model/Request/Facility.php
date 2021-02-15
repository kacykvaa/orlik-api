<?php

declare(strict_types=1);

namespace App\UI\Model\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Facility
{
    /**
     * @Assert\Length(min=2)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    public string $name;

    /**
     * @var mixed|Address
     * @Assert\Valid()
     */
    public $address;

    public int $deleted;

    /**
     * @var array|PitchType
     */
    public $pitchType;
}