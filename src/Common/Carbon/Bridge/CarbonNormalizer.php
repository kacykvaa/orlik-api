<?php

declare(strict_types=1);

namespace App\Common\Carbon\Bridge;

use Carbon\CarbonInterface;
use Monolog\Handler\IFTTTHandler;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CarbonNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        if (!$object instanceof CarbonInterface ){
            throw new \Exception("Object should be Carbon Interface");
        }

        return $object->format(\DateTimeInterface::RFC3339);
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof CarbonInterface;
    }
}