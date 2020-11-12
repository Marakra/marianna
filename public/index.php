<?php
declare(strict_types=1);

use App\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

require_once __DIR__ . '/../vendor/autoload.php';

/** @var RouteCollection $routes */
$routes = require __DIR__ . '/../config/app.php';
$request = Request::createFromGlobals();

$context = (new RequestContext)->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$kernel = new Kernel($matcher, new ControllerResolver(), new ArgumentResolver());
$response = $kernel->handle($request);

$response->send();