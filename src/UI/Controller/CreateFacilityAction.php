<?php


declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Entity\Address as AddressEntity;
use App\Application\Entity\Facility as FacilityEntity;
use App\Application\Repository\FacilityRepository;
use App\Common\Exception\ResourceNotFoundException;
use App\UI\Model\Response\Address as AddressResponse;
use \App\UI\Model\Response\Facility as FacilityResponse;
use App\UI\Model\Request\Facility;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
     * @param FacilityRepository $facilityRepository
     * @return Response
     */
    public function __invoke(Request $request, EntityManagerInterface $em, SerializerInterface $serializer,
                             FacilityRepository $facilityRepository): Response
    {
        try {
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

            $facilityRepository->checkIfFacilityExists(
                $facility->name(),
                $address->street(),
                $address->streetNumber(),
                $address->postCode());

            $em->persist($facility);
            $em->flush();

            $responseAddress = new AddressResponse(
                $address->id(),
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
        } catch (Exception $exception) {
            return new Response('Something bad happened', 500);
        }
    }
}