<?php

declare(strict_types=1);

namespace App\Common\Pagerfanta;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

class Pagerfanta
{
    public function paginate(QueryBuilder $query, $maxPerPage): \Pagerfanta\Pagerfanta
    {
        $adapter = new QueryAdapter($query);
        $pagerfanta = new \Pagerfanta\Pagerfanta($adapter);
        $currentPage = ceil((0 + 1) / $maxPerPage);
        $pagerfanta->setCurrentPage($currentPage);
        $pagerfanta->setMaxPerPage((int)$maxPerPage);
        $pagerfanta->count();
        $pagerfanta->getCurrentPageResults();

        return $pagerfanta;
    }
}