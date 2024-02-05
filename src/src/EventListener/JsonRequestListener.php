<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonRequestListener {
    /**
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!$this->expectsJsonApiRequest($request)) {
            return;
        }
        if (!$this->isJsonRequest($request)) {
            throw new BadRequestHttpException('Content-Type must be application/json');
        }
        if (!$this->isJsonContentValid($request)) {
            throw new BadRequestHttpException('Invalid JSON content');
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isJsonRequest(Request $request): bool
    {
        return 'application/json' === $request->headers->get('Content-Type');
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isJsonContentValid(Request $request): bool
    {
        json_decode($request->getContent());
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function expectsJsonApiRequest(Request $request): bool
    {
        // Проверяем, начинается ли URI с /api/
        return str_starts_with($request->getPathInfo(), '/api/');
    }
}
