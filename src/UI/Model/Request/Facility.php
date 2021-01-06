<?php


declare(strict_types=1);

namespace App\UI\Model\Request;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Facility
{
    /**
     * @Assert\NotBlank(message="You need to pass a name")
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
     * @Assert\NotNull()
     */
    public $address;

}