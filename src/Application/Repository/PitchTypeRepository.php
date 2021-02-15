<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Entity\PitchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PitchTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PitchType::class);
    }

    public function getById(int $id): PitchType
    {
        return $this->createQueryBuilder('pt')
            ->orWhere('pt.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}