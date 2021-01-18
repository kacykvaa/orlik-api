<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Common\UI\Request\Validator\RequestViewModelValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}