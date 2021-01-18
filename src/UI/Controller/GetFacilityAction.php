<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\Common\Exception\ResourceNotFoundException;
use App\Common\UI\Request\Validator\RequestViewModelValidator;
use App\UI\Model\Response\Factory\FacilityViewModelFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetFacilityAction extends AbstractRestAction
{
    private FacilityRepository $facilityRepository;
    private FacilityViewModelFactory $viewModelFactory;

    public function __construct(
        SerializerInterface $serializer,
        RequestViewModelValidator $requestViewModelValidator,
        FacilityRepository $facilityRepository,
        FacilityViewModelFactory $viewModelFactory
    )
    {
        parent::__construct($serializer, $requestViewModelValidator);
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