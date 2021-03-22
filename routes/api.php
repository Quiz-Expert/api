<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Router;

/** @var Router $router */
$router = app()->make(Router::class);

$router->get(
    "/",
    fn (): JsonResponse => response()->json(
        [
            "success" => true,
        ]
    )
);
