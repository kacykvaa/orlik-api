<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\Common\Exception\ResourceNotFoundException;
use App\Common\Pagerfanta\PaginateSearchResult;
use App\Common\UI\Request\Validator\RequestViewModelValidator;
use App\UI\Model\Request\Factory\FacilityFiltersFactory;
use App\UI\Model\Response\Factory\FacilityPitchTypeViewModelFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetFacilitiesAction extends AbstractRestAction
{
    private FacilityRepository $repository;
    private FacilityFiltersFactory $filtersFactory;
    private FacilityPitchTypeViewModelFactory $viewModelFactory;

    public function __construct(
        SerializerInterface $serializer,
        RequestViewModelValidator $requestViewModelValidator,
        FacilityRepository $repository,
        FacilityFiltersFactory $filtersFactory,
        FacilityPitchTypeViewModelFactory $viewModelFactory
    )
    {
        parent::__construct($serializer, $requestViewModelValidator);
        $this->serializer = $serializer;
        $this->requestViewModelValidator = $requestViewModelValidator;
        $this->repository = $repository;
        $this->filtersFactory = $filtersFactory;
        $this->viewModelFactory = $viewModelFactory;
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
            $query = $this->repository->findFacilities($filters);

            $facilities = [];

            foreach ($query as $value) $facilities[] = $this->viewModelFactory->create($value);

            $paginateResult = new PaginateSearchResult($query, $facilities);

            return new Response($this->serializer->serialize($paginateResult, 'json'));

        } catch (ResourceNotFoundException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}