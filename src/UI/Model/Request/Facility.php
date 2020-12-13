<?php

namespace App\UI\Model\Request;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

 class Facility
{
     /**
      * @Assert\NotBlank(message="You need to pass a name")
      * @Assert\NotNull()
      */
    public $name;
     /**
      * @Assert\NotNull()
      * @Assert\NotBlank
      * @ORM\Column(type="array")
      */
    public $pitchTypes = [];
     /**
      * @var mixed|\App\Application\Entity\Address
      * @Assert\NotNull()
      */
    public $address;
}