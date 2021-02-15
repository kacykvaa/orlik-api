<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Entity\Facility;
use App\Common\Exception\ResourceNotFoundException;
use App\Common\Filters\Filters;
use App\Common\Pagerfanta\Pagerfanta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FacilityRepository extends ServiceEntityRepository
{
    private Pagerfanta $pagerfanta;

    public function __construct(ManagerRegistry $registry, Pagerfanta $pagerfanta)
    {
        parent::__construct($registry, Facility::class);
        $this->pagerfanta = $pagerfanta;
    }

    public function getById(int $id): Facility
    {
        $facility = $this->createQueryBuilder('f')
            ->orWhere('f.id = :id AND f.deleted = false')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$facility) {
            throw new ResourceNotFoundException('Facility not found');
        }
        return $facility;
    }

    public function countFacilityByNameAndAddress(string $name, string $street, string $streetNumber, string $postCode): int
    {
        return (int)$this->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->leftJoin('f.address', 'a')
            ->orWhere('f.name = :name')
            ->orWhere('a.street = :street AND a.streetNumber = :streetNumber AND a.postCode = :postCode')
            ->AndWhere('f.deleted = false')
            ->setParameter('name', $name)
            ->setParameter('street', $street)
            ->setParameter('streetNumber', $streetNumber)
            ->setParameter('postCode', $postCode)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countFacilityByName(string $name): int
    {
        return (int)$this->createQueryBuilder('f')
            ->select('COUNT(n.id)')
            ->Where('f.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findFacilities(Filters $filters): \Pagerfanta\Pagerfanta
    {
        $query = $this->createQueryBuilder('f');

        if ($filters->hasFilter('name')) {
            $nameToSearch = str_replace(' ', '', mb_strtolower($filters->filterByKey('name')));
            $query->andWhere('f.nameToSearch LIKE :nameToSearch')
                ->setParameter('nameToSearch', '%' . $nameToSearch . '%');
        }

        if ($filters->hasFilter('pitchTypes')) {
            $pitchTypes = $filters->filterByKey('pitchTypes');
            $query
                ->leftJoin('f.facilityPitchTypes', 'fpt')
                ->leftJoin('fpt.pitchType', 'pt')
                ->andWhere('pt.name IN (:pitchTypeNames)')
                ->setParameter('pitchTypeNames', $pitchTypes);
        }
        $query->andWhere('f.deleted = false');
        $query->getQuery()->getResult();

        if ($filters->hasFilter('maxPerPage')){
             $maxPerPage = $filters->filterByKey('maxPerPage');
        }

        return $this->pagerfanta->paginate($query, $maxPerPage = 10);
    }
}
