<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Quiz\Http\Controllers\Auth\LoginController;
use Quiz\Http\Controllers\Auth\LogoutController;
use Quiz\Http\Controllers\Auth\RegisterController;
use Quiz\Http\Controllers\Auth\UserController;

Route::prefix("auth")->group(function (): void {
    Route::post("login", LoginController::class);
    Route::post("register", RegisterController::class);

    Route::middleware("auth:sanctum")->group(function (): void {
        Route::get("user", UserController::class);
        Route::post("logout", LogoutController::class);
    });
});
