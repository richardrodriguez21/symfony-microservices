<?php

declare(strict_types=1);

namespace App\Controller;
use App\Http\DTO\RegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\RegisterActionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class RegisterAction extends AbstractController
{

  public function __construct(private readonly RegisterActionService $registerActionService){

  }

    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function __invoke(RegisterRequest $registerRequest): JsonResponse
    {
      $this->registerActionService->__invoke($registerRequest->getName(), $registerRequest->getEmail());
      return new JsonResponse($registerRequest->getEmail() . ' ' . $registerRequest->getName());
    }
}