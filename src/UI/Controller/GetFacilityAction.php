<?php


declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\Common\Exception\ResourceNotFoundException;
use App\UI\Model\Response\Address as AddressResponse;
use App\UI\Model\Response\Facility as FacilityResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetFacilityAction extends AbstractRestAction
{
    private SerializerInterface $serializer;
    private FacilityRepository $facilityRepository;

    public function __construct(SerializerInterface $serializer, FacilityRepository $facilityRepository)
    {
        $this->serializer = $serializer;
        $this->facilityRepository = $facilityRepository;
    }

    /**
     * @Route("/api/facilities/{id}", name="get_facility", methods={"GET"} )
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id): Response
    {
        try {
            $facility = $this->facilityRepository->getById($id);

            $address = $facility->address();
            $responseAddress = new AddressResponse($address->id(),
                $address->street(),
                $address->streetNumber(),
                $address->city(),
                $address->postCode());
            $responseFacility = new FacilityResponse($facility->id(),
                $facility->name(),
                $facility->pitchTypes(),
                $responseAddress,
                $facility->createdAt());

            return new Response($this->serializer->serialize($responseFacility, 'json'));

        } catch (ResourceNotFoundException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}