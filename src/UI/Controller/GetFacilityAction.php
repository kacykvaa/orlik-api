<?php

namespace App\UI\Controller;

use Symfony\Component\Routing\Annotation\Route;

class GetFacilityAction extends AbstractRestAction
{
    /**
     * @Route("/api/get/facility", name="get_facility")
     */
    public function __invoke()
    {
        dd("działa");
    }
}