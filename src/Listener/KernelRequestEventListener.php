<?php

namespace App\Listener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

#[AsEventListener(event: 'kernel.request', method: 'onKernelRequest')]
class KernelRequestEventListener
{
    private string $apiToken;

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        // allow access to swagger
        if ($request->getRequestUri() === "/api") {
            return;
        }

        $token = $request->query->get('token') ?? null;

        if (!$token || $token !== $this->apiToken) {
            throw new AccessDeniedHttpException();
        }
    }
}
