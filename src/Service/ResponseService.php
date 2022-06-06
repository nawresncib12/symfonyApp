<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseService
{
    private $serializer;
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    public function createResponse($data): Response
    {
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($data));

        return $response;
    }
    public function serializeResponse($content): Response
    {
        $response = new Response(
            $this->serializer->serialize($content, JsonEncoder::FORMAT),
            200,
            array_merge([], ['Content-Type' => 'application/json;charset=UTF-8'])
        );
        return $response;
    }
}

$containerBuilder = new ContainerBuilder();
$containerBuilder->register('ResponseService', 'ResponseService');
