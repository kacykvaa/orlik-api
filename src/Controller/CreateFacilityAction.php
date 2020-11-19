<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\Facility;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateFacilityAction extends AbstractController
{
    /**
     * @Route("/api/create/facility", name="create_facility")
     */
    public function __invoke(EntityManagerInterface $em)
    {
        $orlik1 = new Facility();
        $orlik1->setName("arena");
        $address = new ArrayCollection();
        $address->add(new Adress("miła", "17", "pruszków", "12-123"));
        $orlik1->setAddress($address);


        $em->persist($orlik1);
        $em->flush();

        return new Response('Saved facility with id '.$orlik1->getId());
    }
}
