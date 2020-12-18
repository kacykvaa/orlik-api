<?php

namespace App\UI\Model\Response;

use App\UI\Model\Request\Address;
use Carbon\CarbonInterface;

class Facility

{
    public string $name;
    public array $pitchTypes;
    // Czy to moze byc response
    public \App\UI\Model\Response\Address $address;
    public CarbonInterface $createdAt;

        public function __construct(string $name, array $pitchTypes, \App\UI\Model\Response\Address $address, CarbonInterface $createdAt)
    {
        $this->name = $name;
        $this->pitchTypes = $pitchTypes;
        $this->address = $address;
        $this->createdAt = $createdAt;
    }
}