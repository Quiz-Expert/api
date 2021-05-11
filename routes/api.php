<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Quiz\Http\Controllers\Auth\LoginController;
use Quiz\Http\Controllers\Auth\LogoutController;
use Quiz\Http\Controllers\Auth\RegisterController;
use Quiz\Http\Controllers\Auth\UserController as AuthUserController;
use Quiz\Http\Controllers\CategoryController;
use Quiz\Http\Controllers\FriendController;
use Quiz\Http\Controllers\GameController;
use Quiz\Http\Controllers\GameInviteController;
use Quiz\Http\Controllers\MistakeController;
use Quiz\Http\Controllers\NotificationController;
use Quiz\Http\Controllers\QuestionController;
use Quiz\Http\Controllers\SuggestionController;
use Quiz\Http\Controllers\UploadController;
use Quiz\Http\Controllers\UserController;

Route::prefix("auth")->group(function (): void {
    Route::post("login", LoginController::class);
    Route::post("register", RegisterController::class);

    Route::middleware("auth:sanctum")->group(function (): void {
        Route::get("user", AuthUserController::class);
        Route::post("logout", LogoutController::class);
    });
});

Route::prefix("upload")->group(function (): void {
    Route::post("icons", [UploadController::class, "storeIcon"]);
});

Route::middleware("auth:sanctum")->group(function (): void {
    Route::get("suggestions", [SuggestionController::class, "index"]);
    Route::post("suggestions", [SuggestionController::class, "store"]);
    Route::get("suggestions/{suggestion}", [SuggestionController::class, "show"]);
    Route::post("suggestions/{suggestion}/accept", [SuggestionController::class, "accept"]);
    Route::post("suggestions/{suggestion}/reject", [SuggestionController::class, "reject"]);

    Route::get("mistakes", [MistakeController::class, "index"]);
    Route::post("mistakes", [MistakeController::class, "store"]);
    Route::get("mistakes/{mistake}", [MistakeController::class, "show"]);
    Route::post("mistakes/{mistake}/close", [MistakeController::class, "close"]);

    Route::get("categories", [CategoryController::class, "index"]);
    Route::get("categories/all", [CategoryController::class, "all"]);
    Route::post("categories", [CategoryController::class, "store"]);
    Route::get("categories/{category}", [CategoryController::class, "show"]);
    Route::put("categories/{category}", [CategoryController::class, "update"]);
    Route::delete("categories/{category}", [CategoryController::class, "delete"]);

    Route::get("questions", [QuestionController::class, "index"]);
    Route::post("questions", [QuestionController::class, "store"]);
    Route::get("questions/{question}", [QuestionController::class, "show"]);
    Route::put("questions/{question}", [QuestionController::class, "update"]);
    Route::delete("questions/{question}", [QuestionController::class, "delete"]);

    Route::get("users", [UserController::class, "index"]);

    Route::get("notifications", [NotificationController::class, "index"]);
    Route::get("notifications/unread", [NotificationController::class, "unread"]);
    Route::get("notifications/unread/count", [NotificationController::class, "unreadCount"]);
    Route::post("notifications/message", [NotificationController::class, "message"]);
    Route::post("notifications/mark-all-as-read", [NotificationController::class, "markAllAsRead"]);
    Route::post("notifications/{notification}/mark-read", [NotificationController::class, "markAsRead"]);

    Route::get("friends", [FriendController::class, "friends"]);
    Route::post("friends/{friend}/unfriend", [FriendController::class, "unfriend"]);

    Route::post("friend-requests", [FriendController::class, "createFriendRequest"]);
    Route::get("friend-requests/sent", [FriendController::class, "sentFriendRequests"]);
    Route::get("friend-requests/incoming", [FriendController::class, "incomingFriendRequests"]);

    Route::post("friend-requests/{friendRequestId}/accept", [FriendController::class, "acceptFriendRequest"]);
    Route::post("friend-requests/{friendRequestId}/reject", [FriendController::class, "rejectFriendRequest"]);
    Route::post("friend-requests/{friendRequestId}/cancel", [FriendController::class, "cancelFriendRequest"]);

    Route::get("game-invites", [GameInviteController::class, "incoming"]);
    Route::post("game-invites", [GameInviteController::class, "store"]);

    Route::post("game-invites/{gameInvite}/accept", [GameInviteController::class, "accept"]);
    Route::post("game-invites/{gameInvite}/reject", [GameInviteController::class, "reject"]);
    Route::post("game-invites/{gameInvite}/cancel", [GameInviteController::class, "cancel"]);

    Route::post("game/{game}/answer", [GameController::class, "answer"]);
});

Broadcast::routes([
    "middleware" => ["auth:sanctum"],
]);
