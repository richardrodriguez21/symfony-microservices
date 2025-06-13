<?php

declare(strict_types=1);

namespace App\Http;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
final class TransformResponseToJsonOnKernelErrors implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $statusCode = $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : 500;

        $response = new JsonResponse([
            'error' => [
                'class' => $exception::class,
                'code' => $statusCode,
                'message' => $exception->getMessage(),
            ],
        ], $statusCode);

        $response->headers->set('Server-Time', (string) microtime(true));
        $response->headers->set('X-Error-Code', (string) $statusCode);

        $event->setResponse($response);
    }
}