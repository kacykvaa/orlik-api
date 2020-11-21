<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Facility;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateFacilityAction extends AbstractController
{
    /**
     * @Route("/api/create/facility", name="create_facility")
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function __invoke(SerializerInterface $serializer)
    {
        $orlik1 = new Facility();
        $orlik1->setName("arena");
        $address = new ArrayCollection();
        $address->add(new Address("miła", "17", "pruszków", "12-123"));
        $orlik1->setAddress($address);
        $orlik1->setPitchTypes(["Football", "Volleyball", "Basketball"]);

        $jsonContent= $serializer->serialize($orlik1, 'json');
        return new JsonResponse('Saved Facility: '.$jsonContent);

    }
}
