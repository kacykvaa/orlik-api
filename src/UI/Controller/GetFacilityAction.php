<?php

namespace App\UI\Controller;

use App\Application\Entity\Facility;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetFacilityAction extends AbstractRestAction
{
    /**
     * @Route("/api/get/facility/{id}", name="get_facility")
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id, SerializerInterface $serializer): Response
    {
        $getFacility = $this->getDoctrine()
            ->getRepository(Facility::class)
            ->find($id);

        if (!$id) {
            throw $this->createNotFoundException(
                'No facility found for id ' . $id
            );
        }

        return new Response($serializer->serialize($getFacility, 'json'));
    }
}