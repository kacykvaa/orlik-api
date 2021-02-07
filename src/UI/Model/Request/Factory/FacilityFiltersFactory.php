<?php

declare(strict_types=1);

namespace App\UI\Model\Request\Factory;

use App\Common\Filters\Filters;
use Symfony\Component\HttpFoundation\Request;

class FacilityFiltersFactory
{
    public function create(Request $request): Filters
    {
        $filters = $request->query->all();
        return new Filters($filters);
    }
}