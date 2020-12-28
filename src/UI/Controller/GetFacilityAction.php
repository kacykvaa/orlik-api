<?php

namespace App\UI\Controller;

use App\Application\Entity\Facility as FacilityEntity;
use App\UI\Model\Response\Address as AddressResponse;
use App\UI\Model\Response\Facility as FacilityResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetFacilityAction extends AbstractRestAction
{
    /**
     * @Route("/api/get/facility/{id}", name="get_facility")
     * @param int $id
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function __invoke(int $id, SerializerInterface $serializer): Response
    {
        $facility = $this->getDoctrine()
            ->getRepository(FacilityEntity::class)
            ->find($id);

        $address = $facility->address();
        $responseAddress = new AddressResponse($address->id() ,$address->street(), $address->streetNumber(),
            $address->city(), $address->postCode());
        $responseFacility = new FacilityResponse($facility->id(), $facility->name(), $facility->pitchTypes(), $responseAddress,
            $facility->createdAt());
        return new Response($serializer->serialize($responseFacility, 'json'));
    }
}