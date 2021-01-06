<?php


declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Entity\Facility;
use App\Common\Exception\DuplicateEntityException;
use App\Common\Exception\ResourceNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FacilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facility::class);
    }

    public function getById(int $id): Facility
    {
        $facility = $this->find($id);
        if (!$facility) {
            throw new ResourceNotFoundException('Facility not found');
        }
        return $facility;
    }

    public function assertFacilityDoesNotExist(string $name, string $street, string $streetNumber, string $postCode)
    {
        $count = (int)$this->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->leftJoin('f.address', 'a')
            ->orWhere('f.name = :name')
            ->orWhere('a.street = :street AND a.streetNumber = :streetNumber AND a.postCode = :postCode')
            ->setParameter('name', $name)
            ->setParameter('street', $street)
            ->setParameter('streetNumber', $streetNumber)
            ->setParameter('postCode', $postCode)
            ->getQuery()
            ->getSingleScalarResult();

        if ($count !== 0){
            throw new DuplicateEntityException('Facility already exists');
        }
    }
}
