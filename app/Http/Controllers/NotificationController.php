<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;
use Quiz\Http\Resources\Notification\NotificationCollection;
use Quiz\Notifications\MessageNotifcation;

class NotificationController extends Controller
{
    public function index(Request $request): ResourceCollection
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate();

        return new NotificationCollection($notifications);
    }

    public function unread(Request $request): ResourceCollection
    {
        $notifications = $request->user()
            ->unreadNotifications()
            ->paginate();

        return new NotificationCollection($notifications);
    }

    public function unreadCount(Request $request): JsonResponse
    {
        return response()->json([
            "data" => $request->user()->unreadNotifications()->count(),
        ]);
    }

    public function message(Request $request): Response
    {
        $message = $request->get("message", "Hello world!");

        $request->user()->notify(new MessageNotifcation($message));

        return response()->noContent();
    }

    public function markAllAsRead(Request $request): Response
    {
        $request->user()
            ->unreadNotifications()
            ->update([
                "read_at" => now(),
            ]);

        return response()->noContent();
    }

    public function markAsRead(DatabaseNotification $notification): Response
    {
        $notification->markAsRead();

        return response()->noContent();
    }
}
