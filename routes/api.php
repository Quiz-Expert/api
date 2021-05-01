<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Quiz\Http\Controllers\Auth\LoginController;
use Quiz\Http\Controllers\Auth\LogoutController;
use Quiz\Http\Controllers\Auth\RegisterController;
use Quiz\Http\Controllers\Auth\UserController;
use Quiz\Http\Controllers\CategoryController;
use Quiz\Http\Controllers\QuestionController;
use Quiz\Http\Controllers\UploadController;

Route::prefix("auth")->group(function (): void {
    Route::post("login", LoginController::class);
    Route::post("register", RegisterController::class);

    Route::middleware("auth:sanctum")->group(function (): void {
        Route::get("user", UserController::class);
        Route::post("logout", LogoutController::class);
    });
});

Route::prefix("upload")->group(function (): void {
    Route::post("icons", [UploadController::class, "storeIcon"]);
});

Route::get("categories", [CategoryController::class, "index"]);
Route::post("categories", [CategoryController::class, "create"]);
Route::get("categories/{category}", [CategoryController::class, "show"]);
Route::put("categories/{category}", [CategoryController::class, "update"]);
Route::delete("categories/{category}", [CategoryController::class, "delete"]);

Route::get("questions", [QuestionController::class, "index"]);
Route::post("questions", [QuestionController::class, "create"]);
Route::get("questions/{question}", [QuestionController::class, "show"]);
Route::put("questions/{question}", [QuestionController::class, "update"]);
Route::delete("questions/{question}", [QuestionController::class, "delete"]);
