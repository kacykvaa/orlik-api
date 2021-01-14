<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Application\Entity\Address;
use App\Common\Exception\ResourceNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function getById(int $id): Address
    {
        $address = $this->find($id);
        if (!$address) {
            throw new ResourceNotFoundException('Address not found');
        }
        return $address;
    }

    public function countAddressByStreetNumberAndZip(string $street, string $streetNumber, string $postCode): int
    {
        return (int)$this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->orWhere('a.street = :street AND a.streetNumber = :streetNumber AND a.postCode = :postCode')
            ->setParameter('street', $street)
            ->setParameter('streetNumber', $streetNumber)
            ->setParameter('postCode', $postCode)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
