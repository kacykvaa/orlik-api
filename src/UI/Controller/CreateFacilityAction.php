<?php

namespace App\UI\Controller;

use App\Application\Entity\Address;
use App\Application\Entity\Facility;
use App\UI\Form\AddressFormType;
use App\UI\Form\CreateFacilityFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @method saveEntities(array $array)
 */
class CreateFacilityAction extends AbstractRestAction
{
    /**
     * @Route("/api/create/facility", name="create_facility")
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request, EntityManagerInterface $em)
    {
        $data = $this->requestJson($request);
        dd($data);
     $facility = new Facility();
     $form = new CreateFacilityFormType();
//     $form
    }
}
