<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Common\UI\Request\Validator\RequestViewModelValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractRestAction extends AbstractController
{
    protected SerializerInterface $serializer;
    protected RequestViewModelValidator $requestViewModelValidator;

    public function __construct(SerializerInterface $serializer, RequestViewModelValidator $requestViewModelValidator)
    {
        $this->serializer = $serializer;
        $this->requestViewModelValidator = $requestViewModelValidator;
    }

    public function ValidationResponse(array $errorsMessages): Response
    {
        $validationErrors = [
            "error_type" => "validation",
            "error_messages" => $errorsMessages
        ];

        return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
    }
}