<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\Application\Validator\FacilityNameValidator;
use App\Common\Exception\DuplicateEntityException;
use App\Common\Exception\ResourceNotFoundException;
use App\Common\UI\Request\Validator\RequestViewModelValidator;
use App\UI\Model\Request\Facility;
use App\UI\Model\Response\Factory\FacilityViewModelFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateFacilityAction extends AbstractRestAction
{
    private FacilityRepository $facilityRepository;
    private EntityManagerInterface $em;
    private FacilityViewModelFactory $viewModelFactory;
    private FacilityNameValidator $facilityValidator;

    public function __construct(
        SerializerInterface $serializer,
        RequestViewModelValidator $requestViewModelValidator,
        FacilityRepository $facilityRepository,
        EntityManagerInterface $em,
        FacilityViewModelFactory $viewModelFactory,
        FacilityNameValidator $facilityValidator
    )
    {
        parent::__construct($serializer, $requestViewModelValidator);
        $this->facilityRepository = $facilityRepository;
        $this->serializer = $serializer;
        $this->em = $em;
        $this->viewModelFactory = $viewModelFactory;
        $this->facilityValidator = $facilityValidator;
    }

    /**
     * @Route("/api/facilities/{id}", name="update_facility", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function __invoke(int $id, Request $request): Response
    {
        try {
            $facility = $this->facilityRepository->getFacilityById($id);
            /** @var Facility $facilityRequest */
            $facilityRequest = $this->serializer->deserialize($request->getContent(), Facility::class, 'json');

            $validationErrors = $this->requestViewModelValidator->validate($facilityRequest);
            if($validationErrors) return $this->ValidationResponse($validationErrors);

            $facility->updateName($facilityRequest->name);
            $facility->updatePitchTypes($facilityRequest->pitchTypes);

            $this->em->flush();

            $viewModel = $this->viewModelFactory->create($facility);

            return new Response($this->serializer->serialize($viewModel, 'json'));

        } catch (ResourceNotFoundException | DuplicateEntityException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}