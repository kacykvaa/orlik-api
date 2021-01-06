<?php

declare(strict_types=1);


namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\Common\Exception\DuplicateEntityException;
use App\Common\Exception\ResourceNotFoundException;
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
    private SerializerInterface $serializer;
    private EntityManagerInterface $em;
    private FacilityViewModelFactory $viewModelFactory;

    public function __construct(
        FacilityRepository $facilityRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        FacilityViewModelFactory $viewModelFactory
    )
    {
        $this->facilityRepository = $facilityRepository;
        $this->serializer = $serializer;
        $this->em = $em;
        $this->viewModelFactory = $viewModelFactory;
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
            $facility = $this->facilityRepository->getById($id);
            /** @var Facility $facilityRequest */
            $facilityRequest = $this->serializer->deserialize($request->getContent(), Facility::class, 'json');

            $facility->updateFacility($facilityRequest->name, $facilityRequest->pitchTypes);

            $this->facilityRepository->assertFacilityNameDoesNotExist($facilityRequest->name);

            $this->em->flush();

            $viewModel = $this->viewModelFactory->create($facility);

            return new Response($this->serializer->serialize($viewModel, 'json'));

        } catch (ResourceNotFoundException | DuplicateEntityException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}