<?php

declare(strict_types=1);

namespace App\UI\Model\Response;

use Carbon\CarbonInterface;

class Facility
{
    public int $id;
    public string $name;
    public Address $address;
    public CarbonInterface $createdAt;

    public function __construct(
        int $id,
        string $name,
        Address $address,
        CarbonInterface $createdAt
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->createdAt = $createdAt;
    }
}