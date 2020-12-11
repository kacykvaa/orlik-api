<?php

namespace App\UI\Controller;

use App\Application\Entity\Address;
use App\Application\Entity\Facility as FacilityEntity;
use App\Common\Model\Value\Enum\ChoiceTypeGenerator;
use App\Common\Model\Value\Enum\PitchType;
use App\UI\Form\AddressFormType;
use App\UI\Form\CreateFacilityFormType;
use App\UI\Model\Request\Facility;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        /** @var Facility  $facilityRequest */
        $facilityRequest = $serializer->deserialize($request->getContent(), Facility::class, 'json');
        dd($facilityRequest);
        $facility = new FacilityEntity($facilityRequest->name, $facilityRequest->pitchTypes, $facilityRequest->address);
    }
}
