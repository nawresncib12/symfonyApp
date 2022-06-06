<?php

namespace App\Controller;

use App\Entity\Pet;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\HttpFoundation\Request;

#[Route('/pets', name: 'app_pet')]
class PetController extends AbstractController
{


    #[Route('/add', name: 'pets.add')]
    public function addPet(ManagerRegistry $doctrine, SerializerInterface $serializer)
    {
        $entityManager = $doctrine->getManager();
        $pet = new Pet();
        $pet->setName("Luka");
        $pet->setType("cat");
        $entityManager->persist($pet);
        $entityManager->flush();
        return new Response(
            $serializer->serialize($pet, JsonEncoder::FORMAT),
            200,
            array_merge([], ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }
    #[Route('/addSpec', name: 'pets.addSpec')]
    public function addPetSpecial(Request $request, ManagerRegistry $doctrine, SerializerInterface $serializer)
    {
        echo ($request);
        $entityManager = $doctrine->getManager();
        $pet = new Pet();
        $pet->setName($request->request->get('name'));
        $pet->setType($request->request->get('type'));
        $entityManager->persist($pet);
        $entityManager->flush();
        return new Response(
            $serializer->serialize($pet, JsonEncoder::FORMAT),
            200,
            array_merge([], ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }
}
