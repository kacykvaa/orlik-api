<?php

declare(strict_types=1);


namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\UI\Model\Request\Facility;
use App\UI\Model\Response\Address as AddressResponse;
use App\UI\Model\Response\Facility as FacilityResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateFacilityAction extends AbstractRestAction
{
    private FacilityRepository $facilityRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $em;

    public function __construct(FacilityRepository $facilityRepository, SerializerInterface $serializer,
                                EntityManagerInterface $em)
    {
        $this->facilityRepository = $facilityRepository;
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     * @Route("/api/facilities/{id}", name="update_facility", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function __invoke(int $id, Request $request): Response
    {
        $facility = $this->facilityRepository->getById($id);
        /** @var Facility $facilityRequest */
        $facilityRequest = $this->serializer->deserialize($request->getContent(), Facility::class, 'json');
        $addressRequest = $facilityRequest->address;

        $address = $facility->address();
        $address->updateStreet($addressRequest->street);
        $address->updateStreetNumber($addressRequest->streetNumber);
        $address->updateCity($addressRequest->city);
        $address->updatePostCode($addressRequest->postCode);

        $facility->updateName($facilityRequest->name);
        $facility->updatePitchTypes($facilityRequest->pitchTypes);


        $this->facilityRepository->assertFacilityDoesNotExist(
            $facilityRequest->name,
            $addressRequest->street,
            $addressRequest->streetNumber,
            $addressRequest->postCode);

        $this->em->flush();

        $responseAddress = new AddressResponse($address->id(),
            $addressRequest->street,
            $addressRequest->streetNumber,
            $addressRequest->city,
            $addressRequest->postCode);

        $responseFacility = new FacilityResponse($facility->id(),
        $facilityRequest->name,
        $facilityRequest->pitchTypes,
        $responseAddress,
        $facility->createdAt());

        return new Response($this->serializer->serialize($responseFacility, 'json'));
    }
}