<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    protected function jsonResponse(array $content, int $statusCode = Response::HTTP_OK): Response
    {
        return new JsonResponse($content, $statusCode);
    }
}
