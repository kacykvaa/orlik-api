<?php

declare(strict_types=1);

namespace App\Common\Filters;


class Filters
{
    private array $filters = [];

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function hasFilter(string $key): bool
    {
        return array_key_exists($key, $this->filters);
    }

    /**
     * @param string $key
     * @return string[]|string
     */
    public function filterByKey(string $key)
    {
        if (!$this->hasFilter($key)){
            throw new \InvalidArgumentException('Filters collection doesn\'t contain filter: ' . $key);
        }
        return $this->filters[$key];
    }
}