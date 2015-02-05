<?php
use Phly\Http\Request;
use Phly\Http\Response;

require('./../vendor/autoload.php');
$response = new \Phly\Http\Response();
$request  = \Phly\Http\ServerRequestFactory::fromGlobals($_SERVER);

$application = new \Piggie\Application\Application();

$routes = [
    '/'     => 'Index',
    '/news' => 'News',
];

$application->addMiddleware('router', function (Request $request, Response $response, array $results = []) use ($routes) {
    if (array_key_exists($request->getUri()->getPath(), $routes)) {
        return $routes[$request->getUri()->getPath()];
    }
    $response = $response->withStatus(404, 'Not Found');
    $response->getBody()->write('Page Not Found');
    return $response;
});


$application->addMiddleware('dispatcher', function (Request $request, Response $response, array $results = []) {
    $dispatcher = 'Piggie\\Action\\' . $results['router'];
    $dispatcher = new $dispatcher;
    $return = $dispatcher($request, $response);
    if ($return instanceof Response) {
        return $return;
    }
    $response->getBody()->write($return);
    return $response;
});

$application->run($request, $response);
