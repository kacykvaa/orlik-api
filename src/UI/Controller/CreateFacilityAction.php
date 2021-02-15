<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Entity\Address as AddressEntity;
use App\Application\Entity\Facility as FacilityEntity;
use App\Application\Entity\FacilityPitchType;
use App\Application\Repository\PitchTypeRepository;
use App\Common\Exception\ResourceNotFoundException;
use App\Common\UI\Request\Validator\RequestViewModelValidator;
use App\UI\Model\Request\Facility;
use App\UI\Model\Response\Factory\PitchTypeViewModelFactory;
use App\UI\Model\Response\Factory\FacilityViewModelFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateFacilityAction extends AbstractRestAction
{
    private EntityManagerInterface $em;
    private PitchTypeRepository $pitchTypeRepository;
    private FacilityViewModelFactory $facilityViewModelFactory;
    private PitchTypeViewModelFactory $pitchTypeViewModelFactory;

    public function __construct(
        SerializerInterface $serializer,
        RequestViewModelValidator $requestViewModelValidator,
        EntityManagerInterface $em,
        PitchTypeRepository $pitchTypeRepository,
        FacilityViewModelFactory $facilityViewModelFactory,
        PitchTypeViewModelFactory $pitchTypeViewModelFactory
    )
    {
        parent::__construct($serializer, $requestViewModelValidator);
        $this->requestViewModelValidator = $requestViewModelValidator;
        $this->em = $em;
        $this->pitchTypeRepository = $pitchTypeRepository;
        $this->facilityViewModelFactory = $facilityViewModelFactory;
        $this->pitchTypeViewModelFactory = $pitchTypeViewModelFactory;
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
            if ($validationErrors) return $this->ValidationResponse($validationErrors);

            $facility = new FacilityEntity($facilityRequest->name);
            $address = new AddressEntity(
                $requestAddress->street,
                $requestAddress->streetNumber,
                $requestAddress->city,
                $requestAddress->postCode,
                $facility
            );
            $facility->updateAddress($address);

            $pitchTypes = array_column($facilityRequest->pitchType, 'id');
            $facilityPitchTypes = [];

            foreach ($pitchTypes as $value) {
                $pitchType = $this->pitchTypeRepository->getById($value);
                $facilityPitchTypes[] = new FacilityPitchType(true, $facility, $pitchType);
            }
            foreach ($facilityPitchTypes as $value) $this->em->persist($value);

            $this->em->persist($facility);
            $this->em->flush();

            $facilityPitchTypesViewModel=[];

            foreach ($facilityPitchTypes as $value){
                $facilityPitchTypesViewModel[] = $this->pitchTypeViewModelFactory->create($value);
            }
            $viewModel = [$this->facilityViewModelFactory->create($facility), $facilityPitchTypesViewModel];

            return new Response($this->serializer->serialize($viewModel, 'json'));

        } catch (ResourceNotFoundException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}