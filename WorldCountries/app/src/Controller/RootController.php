<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path:'api', name:'app_api_root')]
final class RootController extends AbstractController
{
    #[Route(path:'/', name: 'app_api_root_index', methods:['GET'])]
    public function index(): JsonResponse
    {
         return $this->json(data: [
            'message' => 'server is running'
        ]);
    }

    #[Route(path:'/ping', name: 'app_api_root_ping', methods:['GET'])]
    public function ping(): JsonResponse
    {
        return $this->json(data: [
            'status' => 'pong',
        ]);
    }
}
