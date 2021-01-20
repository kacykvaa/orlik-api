<?php

declare(strict_types=1);

namespace App\UI\Model\Request;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Common\UI\Request\Validator\Constraints as AcmeAssert;

class Facility
{
    /**
     * @AcmeAssert\UniqueFacilityName()
     * @Assert\Length(min=5)
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