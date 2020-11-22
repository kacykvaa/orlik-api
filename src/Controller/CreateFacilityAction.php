<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Facility;
use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @method saveEntities(array $array)
 */
class CreateFacilityAction extends AbstractController
{
    /**
     * @Route("/api/create/facility", name="create_facility")
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function __invoke(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $orlik1 = new Facility();
        $orlik1->setName("szkoła");
        $orlik1->setAddress(new Address('miła', '12','krakow', '12-521'));
        $orlik1->setPitchTypes(["Football", "Volleyball", "Basketball"]);
        $orlik1->addImage(new Image('image', 'app/folder'));


        $jsonContent= $serializer->serialize($orlik1, 'json', [
            ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object){
                return $object->getId();
            }
        ]);
        $em->persist($orlik1);
        $em->flush();

        return new JsonResponse($jsonContent, '201');

    }
}
