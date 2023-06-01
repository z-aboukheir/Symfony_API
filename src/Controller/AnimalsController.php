<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AnimalsRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Animals;
use App\Entity\Country;


#[Route('/animal')]
class AnimalsController extends AbstractController
{


    #[Route('/', name: 'app_animal_index', methods: ['GET'])]
    public function index(AnimalsRepository $animalsRepository): Response
    {
        $animalsObjects = $animalsRepository->findAll();
        $animalsArray = [];

        foreach ($animalsObjects as $animal) {
            $animalsArray[] = [
                'id' => $animal->getId(),
                'name' => $animal->getName(),
            ];
        }

        return $this->json($animalsArray);
    }


    #[Route('/{countryCode}', name: 'animals_by_country', methods: ['GET'])]
    public function showByCountry(string $countryCode, CountryRepository $countryRepository): Response
    {
        $country = $countryRepository->findOneBy(['countryCode' => $countryCode]);

        if (!$country) {
            throw $this->createNotFoundException(
                'No country found with code ' . $countryCode
            );
        }

        $animalsObjects = $country->getAnimals();
        $animalsArray = [];

        foreach ($animalsObjects as $animal) {
            $animalsArray[] = [
                'id' => $animal->getId(),
                'name' => $animal->getName(),
            ];
        }

        return $this->json([
            'country' => $country->getName(),
            'animals' => $animalsArray
        ]);
    }


    #[Route('/{id}', name: 'animals_show', methods: ['GET'])]
    public function show(int $id, AnimalsRepository $animalsRepository): Response
    {
        $animal = $animalsRepository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException(
                'No animal found with id ' . $id
            );
        }

        $animalArray = [
            'id' => $animal->getId(),
            'name' => $animal->getName(),
            'averageSize' => $animal->getAverageSize(),
            'averageLife' => $animal->getAverageLife(),
            'martialArt' => $animal->getMartialArt(),
            'number' => $animal->getNumber(),
            'country' => $animal->getCountry() ? $animal->getCountry()->getName() : null,
        ];

        return $this->json($animalArray, Response::HTTP_OK);
    }

    #[Route('/', name: 'animals_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, CountryRepository $countryRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $country = $countryRepository->find($data['country_id']);

        if (!$country) {
            throw $this->createNotFoundException(
                'No country found with id ' . $data['country_id']
            );
        }

        $animal = new Animals();
        $animal->setName($data['name']);
        $animal->setAverageSize($data['averageSize']);
        $animal->setAverageLife($data['averageLife']);
        $animal->setMartialArt($data['martialArt']);
        $animal->setNumber($data['number']);
        $animal->setCountry($country);

        $entityManager->persist($animal);
        $entityManager->flush();

        $animalArray = [
            'id' => $animal->getId(),
            'name' => $animal->getName(),
            'averageSize' => $animal->getAverageSize(),
            'averageLife' => $animal->getAverageLife(),
            'martialArt' => $animal->getMartialArt(),
            'number' => $animal->getNumber(),
            'country' => $animal->getCountry() ? $animal->getCountry()->getName() : null,
        ];

        return $this->json($animalArray, Response::HTTP_CREATED);
    }


    #[Route('/{id}', name: 'animals_delete', methods: ['DELETE'])]
    public function delete(int $id, AnimalsRepository $animalsRepository, EntityManagerInterface $entityManager): Response
    {
        $animal = $animalsRepository->find($id);

        if (!$animal) {
            throw $this->createNotFoundException(
                'No animal found with id ' . $id
            );
        }

        $animalData = [
            'id' => $animal->getId(),
            'name' => $animal->getName(),
            'averageSize' => $animal->getAverageSize(),
            'averageLife' => $animal->getAverageLife(),
            'martialArt' => $animal->getMartialArt(),
            'number' => $animal->getNumber(),
            'country' => $animal->getCountry() ? $animal->getCountry()->getName() : null,
        ];

        $entityManager->remove($animal);
        $entityManager->flush();

        return $this->json($animalData, Response::HTTP_OK);
    }



    #[Route('/{id}', name: 'animals_update', methods: ['PUT'])]
    public function update(int $id, Request $request, AnimalsRepository $animalsRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
    
        $animal = $animalsRepository->find($id);
    
        if (!$animal) {
            throw $this->createNotFoundException(
                'No animal found with id ' . $id
            );
        }
    
        $animal->setName($data['name']);
        $animal->setAverageSize($data['averageSize']);
        $animal->setAverageLife($data['averageLife']);
        $animal->setMartialArt($data['martialArt']);
        $animal->setNumber($data['number']);
    
        $entityManager->flush();
    
        $animalArray = [
            'id' => $animal->getId(),
            'name' => $animal->getName(),
            'averageSize' => $animal->getAverageSize(),
            'averageLife' => $animal->getAverageLife(),
            'martialArt' => $animal->getMartialArt(),
            'number' => $animal->getNumber(),
            'country' => $animal->getCountry() ? $animal->getCountry()->getName() : null,
        ];
    
        return $this->json($animalArray);
    }
    
    #[Route('/{id}/country', name: 'animals_update_country', methods: ['PATCH'])]
    public function updateCountry(int $id, Request $request, AnimalsRepository $animalsRepository, CountryRepository $countryRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
    
        $animal = $animalsRepository->find($id);
    
        if (!$animal) {
            throw $this->createNotFoundException(
                'No animal found with id ' . $id
            );
        }
    
        $country = $countryRepository->find($data['country_id']);
    
        if (!$country) {
            throw $this->createNotFoundException(
                'No country found with id ' . $data['country_id']
            );
        }
    
        $animal->setCountry($country);
    
        $entityManager->flush();
    
        $animalArray = [
            'id' => $animal->getId(),
            'name' => $animal->getName(),
            'averageSize' => $animal->getAverageSize(),
            'averageLife' => $animal->getAverageLife(),
            'martialArt' => $animal->getMartialArt(),
            'number' => $animal->getNumber(),
            'country' => $animal->getCountry() ? $animal->getCountry()->getName() : null,
        ];
    
        return $this->json($animalArray);
    }
    
}
