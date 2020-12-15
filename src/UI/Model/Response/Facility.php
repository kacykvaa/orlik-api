<?php

namespace App\UI\Model\Response;

use App\UI\Model\Request\Address;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTime;

class Facility

{
    public string $name;
    public array $pitchTypes;
    public Address $address;
    public CarbonInterface $createdAt;

    public function __construct(string $name, array $pitchTypes, $address, CarbonInterface $createdAt)
    {
        $this->name = $name;
        $this->pitchTypes = $pitchTypes;
        $this->address = $address;
        $this->createdAt = $createdAt;
    }
}