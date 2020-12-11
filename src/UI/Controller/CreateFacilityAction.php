<?php

namespace App\UI\Controller;

use App\Application\Entity\Address;
use App\Application\Entity\Facility;
use App\UI\Form\AddressFormType;
use App\UI\Form\CreateFacilityFormType;
use App\UI\Model\AddressDTO;
use App\UI\Model\CreateFacilityDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @method saveEntities(array $array)
 */
class CreateFacilityAction extends AbstractController
{
    /**
     * @Route("/api/create/facility", name="create_facility")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);

        $addressForm = $this->createForm(AddressFormType::class);
        $addressForm->submit($data);
        /**@var AddressDTO $addressDto */
        $addressDto = $addressForm->getData();dd(var_dump($addressDto->street));
        $addAddress = new Address($addressDto->street, $addressDto->streetNumber,
            $addressDto->city,$addressDto->postCode);


            $em = $this->getDoctrine()->getManager();
            $em->persist($addAddress);
            $em->flush();
//            return new Response($data, 201);
//        }
        return new Response($addAddress, 201);

    }
}
