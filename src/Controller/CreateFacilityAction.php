<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Facility;
use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
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
        $data = file_get_contents('php://input');
        $facility = json_decode($data);
        var_dump($facility);die();
//        $facility = new Facility($data);
            $jsonContent= $serializer->serialize($facility, 'json', [
            ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object){
                return $object->getId();
            }
        ]);
        $em->persist($facility);
        $em->flush();
        return new JsonResponse($jsonContent, 201);
    }
}
