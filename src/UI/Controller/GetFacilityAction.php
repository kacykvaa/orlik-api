<?php


declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Entity\Facility as FacilityEntity;
use App\Application\Repository\FacilityRepository;
use App\Common\Exception\ResourceNotFoundException;
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
     * @param FacilityRepository $facilityRepository
     * @return Response
     */
    public function __invoke(int $id, SerializerInterface $serializer, FacilityRepository $facilityRepository): Response
    {
        try {
            $facility = $facilityRepository->getById($id);

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

            return new Response($serializer->serialize($responseFacility, 'json'));
        } catch (ResourceNotFoundException $exception) {
            return new Response($exception->getMessage(), 404);
        } catch (\Exception $exception) {
            return new Response('Something bad happen', 500);
        }
    }
}