<?php

namespace App\UI\Controller;

use App\Application\Entity\Facility as FacilityEntity;
use App\UI\Model\Request\Facility;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @method saveEntities(array $array)
 */
class CreateFacilityAction extends AbstractRestAction
{
    /**
     * @Route("/api/create/facility", name="create_facility")
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        /** @var Facility $facilityRequest */
        $facilityRequest = $serializer->deserialize($request->getContent(), Facility::class, 'json');
        $facility = new FacilityEntity($facilityRequest->name, $facilityRequest->pitchTypes, $facilityRequest->address);

        $em->persist($facility);
        $em->flush();

    }
}
