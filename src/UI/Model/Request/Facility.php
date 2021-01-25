<?php

declare(strict_types=1);

namespace App\UI\Model\Request;

use Doctrine\ORM\Mapping as ORM;
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
     * @Assert\NotNull()
     * @Assert\NotBlank
     * @ORM\Column(type="array")
     */
    public array $pitchTypes = [];
    /**
     * @var mixed|Address
     * @Assert\Valid()
     */
    public $address;

}