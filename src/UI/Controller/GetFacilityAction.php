<?php


declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\Common\Exception\ResourceNotFoundException;
use App\UI\Model\Response\Address as AddressResponse;
use App\UI\Model\Response\Facility as FacilityResponse;
use App\UI\Model\Response\Factory\FacilityViewModelFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetFacilityAction extends AbstractRestAction
{
    private SerializerInterface $serializer;
    private FacilityRepository $facilityRepository;
    private FacilityViewModelFactory $viewModelFactory;

    public function __construct(
        SerializerInterface $serializer,
        FacilityRepository $facilityRepository,
        FacilityViewModelFactory $viewModelFactory
    )
    {
        $this->serializer = $serializer;
        $this->facilityRepository = $facilityRepository;
        $this->viewModelFactory = $viewModelFactory;
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

            $viewModel = $this->viewModelFactory->create($facility);

            return new Response($this->serializer->serialize($viewModel, 'json'));

        } catch (ResourceNotFoundException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}