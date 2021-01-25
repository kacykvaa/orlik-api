<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Repository\AddressRepository;
use App\Common\Exception\DuplicateEntityException;
use App\Common\Exception\ResourceNotFoundException;
use App\Application\Validator\FacilityAddressValidator;
use App\Common\UI\Request\Validator\RequestViewModelValidator;
use App\UI\Model\Request\Address as AddressRequest;
use App\UI\Model\Response\Factory\AddressViewModelFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateAddressAction extends AbstractRestAction
{
    private AddressRepository $addressRepository;
    private AddressViewModelFactory $viewModelFactory;
    private EntityManagerInterface $em;
    private FacilityAddressValidator $addressValidator;

    public function __construct(
        SerializerInterface $serializer,
        RequestViewModelValidator $requestViewModelValidator,
        AddressRepository $addressRepository,
        AddressViewModelFactory $viewModelFactory,
        EntityManagerInterface $em,
        FacilityAddressValidator $addressValidator
    )
    {
        parent::__construct($serializer, $requestViewModelValidator);
        $this->addressRepository = $addressRepository;
        $this->serializer = $serializer;
        $this->viewModelFactory = $viewModelFactory;
        $this->em = $em;
        $this->addressValidator = $addressValidator;
    }

    /**
     * @Route ("/api/address/{id}", name="update_address", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function __invoke(int $id, Request $request): Response
    {
        try {
            $address = $this->addressRepository->getById($id);
            /** @var AddressRequest $addressRequest */
            $addressRequest = $this->serializer->deserialize($request->getContent(), AddressRequest::class, 'json');

            $validationErrors = $this->requestViewModelValidator->validate($addressRequest);
            if($validationErrors) return $this->ValidationResponse($validationErrors);

            $address->updateData(
                $addressRequest->street,
                $addressRequest->streetNumber,
                $addressRequest->city,
                $addressRequest->postCode,
            );

            $this->em->flush();

            $viewModel = $this->viewModelFactory->create($address);

            return new Response($this->serializer->serialize($viewModel, 'json'));

        } catch (ResourceNotFoundException | DuplicateEntityException $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }
}