<?php

declare(strict_types=1);

namespace App\Common\UI\Request\Validator\Constraints;

use App\Application\Repository\FacilityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueFacilityNameValidator extends ConstraintValidator
{
    private EntityManagerInterface $em;
    private FacilityRepository $repository;

    public function __construct(EntityManagerInterface $em, FacilityRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueFacilityName) {
            throw new UnexpectedTypeException($constraint, UniqueFacilityName::class);
        }

        if (null === $value || '' === $value) return;

        if (!is_string($value)) throw new UnexpectedValueException($value, 'string');

        $query = $this->repository->countFacilityByName($value);

        if ($query !== 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}