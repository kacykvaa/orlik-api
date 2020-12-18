<?php

namespace App\UI\Controller;

use App\Application\Entity\Address as AddressEntity;
use App\Application\Entity\Facility;
use App\Application\Entity\Facility as FacilityEntity;
use App\UI\Model\Request\Address;
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
        $getAddress = $facility->address();
        dd($facility->address());
        $address = new \App\UI\Model\Response\Address($getAddress->street(),$getAddress->streetNumber(),$getAddress->city(),$getAddress->postCode());
        $responseFacility = new FacilityResponse($facility->name(), $facility->pitchTypes(), $address, $facility->createdAt());

        return new Response($serializer->serialize($responseFacility, 'json'));
    }
}