<?php

namespace App\Controller;

use App\Entity\Pet;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ResponseService;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

#[Route('/pets', name: 'app_pet')]
class PetController extends AbstractController
{


    #[Route('/add', name: 'pets.add')]
    public function addPet(ManagerRegistry $doctrine,  ResponseService $respServ)
    {
        $entityManager = $doctrine->getManager();
        $pet = new Pet();
        $pet->setName("Luka");
        $pet->setType("cat");
        $entityManager->persist($pet);
        $entityManager->flush();
        return $respServ->serializeResponse($pet);
    }
    #[Route('/addSpec', name: 'pets.addSpec')]
    public function addPetSpecial(Request $request, ManagerRegistry $doctrine,  ResponseService $respServ)
    {
        echo ($request);
        $entityManager = $doctrine->getManager();
        $pet = new Pet();
        $pet->setName($request->request->get('name'));
        $pet->setType($request->request->get('type'));
        $entityManager->persist($pet);
        $entityManager->flush();
        return $respServ->serializeResponse($pet);
    }
}
