<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Entity\Facility;
use App\Common\Exception\ResourceNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FacilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facility::class);
    }

    public function getFacilityById(int $id): Facility
    {
        $facility = $this->createQueryBuilder('a')
            ->orWhere('a.id = :id AND a.deleted = 0')
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
            ->orWhere('f.deleted = 0')
            ->orWhere('f.name = :name')
            ->orWhere('a.street = :street AND a.streetNumber = :streetNumber AND a.postCode = :postCode')
            ->setParameter('name', $name)
            ->setParameter('street', $street)
            ->setParameter('streetNumber', $streetNumber)
            ->setParameter('postCode', $postCode)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countFacilityByName(string $name): int
    {
        return (int)$this->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->Where('n.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
