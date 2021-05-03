<?php

use ByJG\RestServer\HttpRequestHandler;
use ByJG\RestServer\OutputProcessor\JsonOutputProcessor;
use ByJG\RestServer\ResponseBag;
use ByJG\RestServer\Route\RouteDefinition;
use ByJG\RestServer\Route\RoutePattern;

require_once __DIR__ . '/vendor/autoload.php';

$routeDefinition = new RouteDefinition();

$routeDefinition->addRoute(
    RoutePattern::get(
        '/ping',
        JsonOutputProcessor::class,
        function ($response, $request) {  // The Closure for Process the request
            $response->write(["message" => 'pong']);
        }
    )
);

$routeDefinition->addRoute(
    RoutePattern::get(
        '/current-date',
        JsonOutputProcessor::class,
        function ($response, $request) {  // The Closure for Process the request
            $response->write(["message" => date("Y-m-d H:i:s")]);
        }
    )
);

$routeDefinition->addRoute(
    RoutePattern::get(
        '/stress/{n:[0-9]+}',
        JsonOutputProcessor::class,
        function ($response, $request) {
            $result = 0;
            for($i = 0; $i < pow(10, $request->param("n")); $i++) {
                $result += $i;
            }
            $response->write(["message2" => $result]);
        }
    )
);

function fibonacci($n,$first = 0,$second = 1)
{
    $fib = [$first,$second];
    for($i=1;$i<$n;$i++)
    {
        $fib[] = $fib[$i]+$fib[$i-1];
    }
    return $fib;
}


$restServer = new HttpRequestHandler();
try {
    $restServer->handle($routeDefinition);
} catch (Exception $ex) {
    $response = new \ByJG\RestServer\HttpResponse();
    $response->setResponseCode(500);
    $response->write(["error" => $ex->getMessage()]);

    $jsonOutput = new JsonOutputProcessor();
    $jsonOutput->processResponse($response);
}
