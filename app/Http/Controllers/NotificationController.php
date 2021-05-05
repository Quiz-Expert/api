<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
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

    public function message(Request $request): Response
    {
        $message = $request->get("message", "Hello world!");

        $request->user()->notify(new MessageNotifcation($message));

        return response()->noContent();
    }
}
