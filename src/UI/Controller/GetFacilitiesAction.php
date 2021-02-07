<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\Common\Exception\ResourceNotFoundException;
use App\Common\UI\Request\Validator\RequestViewModelValidator;
use App\UI\Model\Request\Factory\FacilityFiltersFactory;
use App\UI\Model\Response\Factory\FacilityViewModelFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetFacilitiesAction extends AbstractRestAction
{
    private FacilityRepository $repository;
    private FacilityViewModelFactory $viewModelFactory;
    private FacilityFiltersFactory $filtersFactory;

    public function __construct(
        SerializerInterface $serializer,
        RequestViewModelValidator $requestViewModelValidator,
        FacilityRepository $repository,
        FacilityViewModelFactory $viewModelFactory,
        FacilityFiltersFactory $filtersFactory
    )
    {
        parent::__construct($serializer, $requestViewModelValidator);
        $this->serializer = $serializer;
        $this->requestViewModelValidator = $requestViewModelValidator;
        $this->repository = $repository;
        $this->viewModelFactory = $viewModelFactory;
        $this->filtersFactory = $filtersFactory;
    }

    /**
     * @Route("/api/facilities", name="get_facilities", methods={"GET"} )
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        try {
            $filters = $this->filtersFactory->create($request);
            $query = $this->repository->FindFacilities($filters);
            $facilities = [];
            foreach ($query as $value) $facilities[] = $this->viewModelFactory->create($value);

            return new Response($this->serializer->serialize($facilities, 'json'));

        } catch (ResourceNotFoundException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}