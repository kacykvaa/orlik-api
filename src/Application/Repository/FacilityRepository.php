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

    public function getById(int $id): Facility
    {
        $facility = $this->find($id);
        if (!$facility) {
            throw new ResourceNotFoundException('Facility not found');
        }
        return $facility;
    }

    public function checkIfFacilityExists(string $name)
    {
        $qb = $this->createQueryBuilder('n')
            ->where('n.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->execute();

        if ($name = $qb){
            throw new ResourceNotFoundException('Facility with that name exists');
        }
    }
}
