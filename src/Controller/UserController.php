<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ResponseService;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/users')]
class UserController extends AbstractController
{

    #[Route('/', name: 'users.list')]
    public function getUsers(ManagerRegistry $doctrine, ResponseService $respServ)
    {
        $repo = $doctrine->getRepository(User::class);
        $users = $repo->findAll();
        return $respServ->serializeResponse($users);
    }

    ##Param converter !!

    #[Route('/{id<\d+>}', name: 'users.detail')]
    public function detail(SerializerInterface $serializer, User $user = null): Response
    {
        $response = new Response(
            $serializer->serialize($user, JsonEncoder::FORMAT),
            200,
            array_merge([], ['Content-Type' => 'application/json;charset=UTF-8'])
        );
        return $response;
    }

    #[Route('/add', name: 'users.add')]
    public function addUser(Request $request, ManagerRegistry $doctrine, ResponseService $respServ)
    {
        $entityManager = $doctrine->getManager();
        $repo = $doctrine->getRepository(Pet::class);
        $user = new User();
        $user->setName($request->request->get('name'));
        $user->setAge($request->request->get('age'));
        $user->setJob($request->request->get('job'));
        $pet = $repo->find($request->request->get('petId'));
        $user->setPet($pet);
        $entityManager->persist($user);
        $entityManager->flush();

        return $respServ->serializeResponse($user);
    }
}
