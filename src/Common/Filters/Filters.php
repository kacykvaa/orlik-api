<?php

declare(strict_types=1);

namespace App\Common\Filters;


class Filters
{
    public array $filters = [];

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }
}