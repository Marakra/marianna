<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\PointService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ApiController extends AbstractController
{
    private PointService $pointService;

    public function __construct(PointService $pointService)
    {
        $this->pointService = $pointService;
    }

    public function getPointInformation(Request $request): Response
    {
        $id = (int) $request->get('id');
        $point = $this->pointService->getPointInformation($id);

        if ($point === null) {
            return $this->jsonResponse(['error' => 'Point with given id not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->jsonResponse($point->toArray());
    }
}
