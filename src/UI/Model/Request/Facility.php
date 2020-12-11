<?php

namespace App\UI\Model\Request;


use Symfony\Component\Validator\Constraints as Assert;

 class Facility
{
    public $name;
    public $pitchTypes = [];
     /**
      * @var mixed|Address
      */
    public $address;
}