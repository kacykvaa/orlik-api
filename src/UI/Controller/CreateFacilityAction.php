<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Entity\Address as AddressEntity;
use App\Application\Entity\Facility as FacilityEntity;
use App\Common\Exception\ResourceNotFoundException;
use App\Common\UI\Request\Validator\RequestViewModelValidator;
use App\UI\Model\Request\Facility;
use App\UI\Model\Response\Factory\FacilityViewModelFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateFacilityAction extends AbstractRestAction
{
    private EntityManagerInterface $em;
    private FacilityViewModelFactory $viewModelFactory;

    public function __construct(
        SerializerInterface $serializer,
        RequestViewModelValidator $requestViewModelValidator,
        EntityManagerInterface $em,
        FacilityViewModelFactory $viewModelFactory
    )
    {
      parent::__construct($serializer, $requestViewModelValidator);
        $this->requestViewModelValidator = $requestViewModelValidator;
        $this->em = $em;
        $this->viewModelFactory = $viewModelFactory;
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

            $validationErrors = $this->requestViewModelValidator->validate($facilityRequest);
            if ($validationErrors){
                 return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
            }

            $facility = new FacilityEntity($facilityRequest->name, $facilityRequest->pitchTypes);
            $address = new AddressEntity(
                $requestAddress->street,
                $requestAddress->streetNumber,
                $requestAddress->city,
                $requestAddress->postCode,
                $facility
            );
            $facility->updateAddress($address);

            $this->em->persist($facility);
            $this->em->flush();

            $viewModel = $this->viewModelFactory->create($facility);

            return new Response($this->serializer->serialize($viewModel, 'json'));

        } catch (ResourceNotFoundException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}