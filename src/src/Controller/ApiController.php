<?php

namespace App\Controller;

use App\Repository\ApartmentRepository;
use App\Repository\HouseRepository;
use App\Repository\PersonRepository;
use App\Requests\CreateApartmentRequest;
use App\Requests\CreateHouseRequest;
use App\Requests\CreatePersonRequest;
use App\Requests\GetApartmentListRequest;
use App\Requests\GetPersonsListRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route("/api", name: "api_")]
class ApiController extends AbstractController
{
    #[Route('/person', name: 'add_person' , methods: ['POST'])]
    public function create_person(Request $request, PersonRepository $repository, SerializerInterface $serializer,
                          ValidatorInterface $validator, ApartmentRepository $apartmentRepository): JsonResponse
    {
        $validate_request = new CreatePersonRequest($validator);
        $raw_data = $validate_request->getRequest()->toArray();

        $apartment = $apartmentRepository->find($raw_data['apartment_id']);
        if (!$apartment) {
            return $this->json(['success' => false, 'errors' => ['Apartment not found']], Response::HTTP_BAD_REQUEST);
        }
        $raw_data = json_decode($request->getContent(), true);
        $birthdate = \DateTime::createFromFormat('Y-m-d', $raw_data['birthdate'] ?? '');
        if (!$birthdate) {
            return $this->json(['success' => false, ['errors' => 'Invalid birthdate format']], 422);
        }
        $existing_person = $repository->findOneBy(['personal_id_number' => $raw_data['personal_id_number']]);
        if ($existing_person) {
            return $this->json(['success' => false, ['errors' => 'Such personal_id_number already exists']], 422);
        }
        $person = $repository->createPerson($raw_data, $apartment);

        return $this->json(['success' => true, 'person_id' => $person->getId()]);
    }
    #[Route('/house', name: 'add_house', methods: ['POST'])]
    public function create_house(Request $request, HouseRepository $repository, ValidatorInterface $validator): JsonResponse
    {
        $validate_request = new CreateHouseRequest($validator);
        $raw_data = $validate_request->getRequest()->toArray();
        $house = $repository->createHouse($raw_data);

        return $this->json(['success' => true, 'house_id' => $house->getId()]);
    }
    #[Route('/apartment', name: 'add_apartment', methods: ['POST'])]
    public function create_apartment(Request $request,  ApartmentRepository $repository, SerializerInterface $serializer,
                                     ValidatorInterface $validator, HouseRepository $houseRepository): JsonResponse
    {
        $validate_request = new CreateApartmentRequest($validator);
        $raw_data = $validate_request->getRequest()->toArray();
        $house = $houseRepository->find($raw_data['house_id']);
        if (!$house) {
            return $this->json(['success' => false, 'errors' => ['House not found']], Response::HTTP_BAD_REQUEST);
        }
        $apartment = $repository->createApartment($raw_data, $house);

        return $this->json(['success' => true, 'apartment_id' => $apartment->getId()]);
    }

    #[Route('/person/list', name: 'get_persons' , methods: ['POST'])]
    public function get_persons_list(Request $request, PersonRepository $repository, SerializerInterface $serializer,
                                  ValidatorInterface $validator ): JsonResponse
    {
        $validate_request = new GetPersonsListRequest($validator);
        $raw_data = $validate_request->getRequest()->toArray();
        if(!empty($raw_data['birthdate']))
        {
            $birthdate = \DateTime::createFromFormat('Y-m-d', $raw_data['birthdate']);
            if (!$birthdate) {
                return $this->json(['success' => false, ['errors' => 'Invalid birthdate format']], 422);
            }
        }
        $persons = $repository->getPersonsByFilters($raw_data);

        return $this->json(['success' => true, 'persons' => $persons]);
    }

    #[Route('/apartment/list', name: 'get_apartments' , methods: ['POST'])]
    public function get_apartment_list(Request $request, ApartmentRepository $repository, SerializerInterface $serializer,
                                  ValidatorInterface $validator): JsonResponse
    {
        $validate_request = new GetApartmentListRequest($validator);
        $raw_data = $validate_request->getRequest()->toArray();
        $apartments = $repository->getApartmentList($raw_data);
        $serialized = $serializer->serialize($apartments, 'json', ['groups' => ['apartment']]);

        return $this->json(['success' => true, 'apartments' => json_decode($serialized)]);
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @return array
     */
    private function formatErrors(\Symfony\Component\Validator\ConstraintViolationListInterface $errors):array
    {
        $res = [];
        foreach ($errors as $error)
        {
            $res[] = $error->getMessage();
        }

        return $res;
    }


}
