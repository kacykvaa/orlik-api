<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Entity\Address as AddressEntity;
use App\Application\Entity\Facility as FacilityEntity;
use App\Application\Repository\FacilityRepository;
use App\Application\Validator\FacilityValidator;
use App\Common\Exception\ResourceNotFoundException;
use App\UI\Model\Request\Facility;
use App\UI\Model\Response\Factory\FacilityViewModelFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateFacilityAction extends AbstractRestAction
{
    private EntityManagerInterface $em;
    private SerializerInterface $serializer;
    private FacilityRepository $facilityRepository;
    private FacilityViewModelFactory $viewModelFactory;
    private FacilityValidator $facilityValidator;

    public function __construct(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        FacilityRepository $facilityRepository,
        FacilityViewModelFactory $viewModelFactory,
        FacilityValidator $facilityValidator
    )
    {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->facilityRepository = $facilityRepository;
        $this->viewModelFactory = $viewModelFactory;
        $this->facilityValidator = $facilityValidator;
    }

    /**
     * @Route("/api/facilities", name="create_facility", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        try {
            /** @var Facility $facilityRequest */
            $facilityRequest = $this->serializer->deserialize($request->getContent(), Facility::class, 'json');

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

            $this->facilityValidator->assertFacilityDoesNotExist(
                $facility->name(),
                $address->street(),
                $address->streetNumber(),
                $address->postCode());

            $this->em->persist($facility);
            $this->em->flush();

            $viewModel = $this->viewModelFactory->create($facility);

            return new Response($this->serializer->serialize($viewModel, 'json'));

        } catch (ResourceNotFoundException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}