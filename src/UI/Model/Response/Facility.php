<?php

declare(strict_types=1);

namespace App\UI\Model\Response;

use Carbon\CarbonInterface;

class Facility
{
    public int $id;

    public string $name;

    public array $pitchTypes;

    public Address $address;

    public CarbonInterface $createdAt;

    public function __construct(int $id, string $name, array $pitchTypes, Address $address, CarbonInterface $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->pitchTypes = $pitchTypes;
        $this->address = $address;
        $this->createdAt = $createdAt;
    }
}