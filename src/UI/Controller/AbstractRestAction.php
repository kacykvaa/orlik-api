<?php
declare(strict_types=1);

namespace App\UI\Controller;


use App\UI\Service\RequestJsonExtractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRestAction extends AbstractController
{
    /**
     * @var RequestJsonExtractor
     */
    private RequestJsonExtractor $jsonExtractor;

    public function __construct(RequestJsonExtractor $jsonExtractor)
    {
        $this->jsonExtractor = $jsonExtractor;
    }

    public function requestJson(Request $request):array
    {
        return $this->jsonExtractor->extract($request);
    }
}