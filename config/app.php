<?php
declare(strict_types=1);

use App\Controller\ApiController;
use App\Controller\IndexController;
use App\Repository\DbPointRepository;
use App\Repository\MockPointRepository;
use App\Service\PointService;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Load environment variables
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

// Initialize services
$pointRepository = new MockPointRepository();

if ($_ENV['MODE'] === 'db') {
    // Configure database
    $pdo = new PDO(
        sprintf(
            'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s',
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_NAME'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD']
        )
    );

    $pointRepository = new DbPointRepository($pdo);
}

$pointService = new PointService($pointRepository);

// Initialize twig
$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

// Initialize routes
$routes = new RouteCollection();

$routes->add(
    'index',
    new Route(
        '/',
        ['_controller' => [new IndexController($twig, $pointService), 'index']]
    )
);
$routes->add(
    'api.get_point_information',
    new Route(
        '/api/v1/point/{id}',
        ['_controller' => [new ApiController($pointService), 'getPointInformation']]
    )
);

return $routes;