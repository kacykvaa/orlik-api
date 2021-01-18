<?php

declare(strict_types=1);

namespace App\Common\UI\Request\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use function iterator_to_array;

class RequestViewModelValidator
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param object $object
     * @return mixed
     */
    public function validate(object $object): array
    {
        $errors = $this->validator->validate($object);
        $errors = iterator_to_array($errors);
        $validationErrors = [];
        foreach ($errors as $error) {
            $validationErrors[$error->getPropertyPath()][] = $error->getMessage();
        }
        return $validationErrors;
    }
}