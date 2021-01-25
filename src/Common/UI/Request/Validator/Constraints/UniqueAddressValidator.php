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
        $query = $this->repository->countAddressByStreetNumberAndCity(
            $value->street,
            $value->streetNumber,
            $value->city,
        );

        if ($query !== 0) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath('street')
                ->addViolation();

            $this->context
                ->buildViolation($constraint->message)
                ->atPath('streetNumber')
                ->addViolation();

            $this->context
                ->buildViolation($constraint->message)
                ->atPath('city')
                ->addViolation();
        }
    }
}