<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/users')]
class TodoController extends AbstractController
{

    #[Route('/', name: 'users.list')]
    public function getUsers(ManagerRegistry $doctrine, SerializerInterface $serializer)
    {
        $repo = $doctrine->getRepository(User::class);
        $users = $repo->findAll();
        $response = new Response(
            $serializer->serialize($users, JsonEncoder::FORMAT),
            200,
            array_merge([], ['Content-Type' => 'application/json;charset=UTF-8'])
        );
        return $response;
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
    public function addUser(ManagerRegistry $doctrine, SerializerInterface $serializer)
    {
        $entityManager = $doctrine->getManager();
        $user = new User();
        $user->setName("nawres");
        $user->setAge(22);
        $user->setJob("Student");
        $entityManager->persist($user);
        $entityManager->flush();
        new Response(
            $serializer->serialize($user, JsonEncoder::FORMAT),
            200,
            array_merge([], ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }
}
