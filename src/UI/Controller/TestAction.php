<?php


declare(strict_types=1);

namespace App\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestAction extends AbstractController
{
    /**
     * @Route(path="/api/test", methods={"GET"})
     */
    public function __invoke(): Response
    {
        return new JsonResponse(['message' => 'Hello world!']);
    }
}