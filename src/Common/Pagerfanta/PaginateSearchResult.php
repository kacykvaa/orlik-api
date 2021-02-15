<?php

declare(strict_types=1);

namespace App\Common\Pagerfanta;

use Pagerfanta\Pagerfanta as Pagerfanta;

class PaginateSearchResult
{
    public array $pagination;
    public array $results;

    public function __construct(Pagerfanta $data, array $facilities)
    {
        $this->addMeta('total', $data->getNbResults());
        $this->addMeta('per page', $data->getMaxPerPage());

        $this->results = $facilities;
    }

    public function addMeta($name, $value)
    {
        $this->setPagination($name, $value);
    }

    public function setPagination($name, $value)
    {
        $this->pagination[$name] = $value;
    }
}