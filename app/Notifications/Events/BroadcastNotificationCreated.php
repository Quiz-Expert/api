<?php

declare(strict_types=1);

namespace Quiz\Notifications\Events;

use Illuminate\Notifications\Events\BroadcastNotificationCreated as BaseBroadcastNotificationCreated;

class BroadcastNotificationCreated extends BaseBroadcastNotificationCreated
{
    public function broadcastAs(): string
    {
        return "incoming_notification";
    }
}
