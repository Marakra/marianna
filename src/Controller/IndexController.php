<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\PointService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class IndexController extends AbstractController
{
    private Environment $twig;
    private PointService $pointService;

    public function __construct(Environment $twig, PointService $pointService)
    {
        $this->twig = $twig;
        $this->pointService = $pointService;
    }

    public function index(Request $request): Response
    {
        return $this->render('index.html.twig', [
            'points' => $this->pointService->getAllPoints()->toArray()
        ]);
    }

    private function render(string $templatePath, array $data = []): Response
    {
        return new Response($this->twig->render($templatePath, $data));
    }
}
