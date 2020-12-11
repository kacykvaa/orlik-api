<?php
declare(strict_types=1);

namespace App\UI\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestJsonExtractor
{
    public function extract(Request $request): array
    {
        $data = json_decode($request->getContent(), true);

        if(json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpException(400, 'Invalid json');
        }

        return $data;
    }
}