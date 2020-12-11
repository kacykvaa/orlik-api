<?php

namespace App\Application\Repository;

use App\Application\Entity\Facility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Facility|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facility|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facility[]    findAll()
 * @method Facility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facility::class);
    }
}
