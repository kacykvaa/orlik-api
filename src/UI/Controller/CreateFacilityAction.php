<?php

namespace App\UI\Controller;

use App\Application\Entity\Address as AddressEntity;
use App\Application\Entity\Facility as FacilityEntity;
use \App\UI\Model\Response\Facility as FacilityResponse;
use App\UI\Model\Request\Facility;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateFacilityAction extends AbstractRestAction
{
    /**
     * @Route("/api/create/facility", name="create_facility")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function __invoke(Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        /** @var Facility $facilityRequest */
        $facilityRequest = $serializer->deserialize($request->getContent(), Facility::class, 'json');

        $requestAddress = $facilityRequest->address;
        $facility = new FacilityEntity($facilityRequest->name, $facilityRequest->pitchTypes);
        $address = new AddressEntity(
            $requestAddress->street,
            $requestAddress->streetNumber,
            $requestAddress->city,
            $requestAddress->postCode,
            $facility
        );
        $facility->updateAddress($address);

        $createdAt = $facility->createdAt();
        $responseFacility = new FacilityResponse($facilityRequest->name, $facilityRequest->pitchTypes, $facilityRequest->address, $createdAt);

        $em->persist($facility);
        $em->flush();

        return new Response($serializer->serialize($responseFacility, 'json'));
    }
}