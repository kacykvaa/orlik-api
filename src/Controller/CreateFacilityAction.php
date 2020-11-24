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
        $facility = new Facility('Gimnazjum',['Football', 'Basketball'],
        new Address('orla', '12','pris','12120'));
        $facility->addImage(new Image('image', 'app/folder'));


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
