<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;
use Illuminate\Contracts\Debug\ExceptionHandler as HandlerContract;
use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Foundation\Application;
use Quiz\Console\Kernel as ConsoleKernel;
use Quiz\Exceptions\Handler;
use Quiz\Http\Kernel as HttpKernel;

$basePath = $_ENV["APP_BASE_PATH"] ?? dirname(__DIR__);

$app = new Application($basePath);

$app->singleton(HttpKernelContract::class, HttpKernel::class);
$app->singleton(ConsoleKernelContract::class, ConsoleKernel::class);
$app->singleton(HandlerContract::class, Handler::class);

return $app;
