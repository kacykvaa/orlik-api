<?php

declare(strict_types=1);

namespace App\Common\UI\Request\Validator\Constraints;

use App\Application\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueAddressValidator extends ConstraintValidator
{
    private EntityManagerInterface $em;
    private AddressRepository $repository;

    public function __construct(EntityManagerInterface $em, AddressRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function validate($value, Constraint $constraint): void
    {
        $query = $this->repository->countAddressByStreetNumberAndZip(
            $value->street,
            $value->streetNumber,
            $value->postCode,
        );

        if ($query !== 0){
            $this->context->buildViolation($constraint->message)
                ->atPath('Address')
                ->addViolation();
        }
    }
}