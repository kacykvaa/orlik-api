<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Repository\FacilityRepository;
use App\Common\UI\Request\Validator\RequestViewModelValidator;
use App\UI\Model\Request\Facility;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DeleteFacilityAction extends AbstractRestAction
{
    private FacilityRepository $facilityRepository;
    private EntityManagerInterface $em;

    public function __construct(
        SerializerInterface $serializer,
        RequestViewModelValidator $requestViewModelValidator,
        FacilityRepository $facilityRepository,
        EntityManagerInterface $em
    )
    {
        parent::__construct($serializer, $requestViewModelValidator);
        $this->serializer = $serializer;
        $this->requestViewModelValidator = $requestViewModelValidator;
        $this->facilityRepository = $facilityRepository;
        $this->em = $em;
    }

    /**
     * @Route("/api/facilities/{id}", name="delete_facility", methods={"DELETE"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function __invoke(Request $request, int $id): Response
    {
        $facility = $this->facilityRepository->getFacilityById($id);
        /** @var Facility $facilityRequest */
        $facilityRequest = $this->serializer->deserialize($request->getContent(), Facility::class, 'json');

        $facility->updateDeleted($facilityRequest->deleted);
        $facility->updateDeletedAt();

        $this->em->flush();

        return new Response(null, 204);
    }
}