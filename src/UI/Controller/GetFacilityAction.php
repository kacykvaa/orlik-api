<?php

namespace App\UI\Controller;

use App\Application\Entity\Facility;
use App\UI\Model\Response\Address;
use App\UI\Model\Response\Facility as FacilityResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetFacilityAction extends AbstractRestAction
{
    /**
     * @Route("/api/get/facility/{id}", name="get_facility")
     * @param Facility $facility
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function __invoke(Facility $facility, SerializerInterface $serializer): Response
    {
        $address = $facility->address();
        $responseAddress = new Address($address->id() ,$address->street(), $address->streetNumber(),
            $address->city(), $address->postCode());
        $responseFacility = new FacilityResponse($facility->id(), $facility->name(), $facility->pitchTypes(), $responseAddress,
            $facility->createdAt());
        return new Response($serializer->serialize($responseFacility, 'json'));
    }
}