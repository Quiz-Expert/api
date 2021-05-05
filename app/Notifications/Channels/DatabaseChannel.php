<?php

declare(strict_types=1);

namespace Quiz\Notifications\Channels;

use Illuminate\Notifications\Channels\DatabaseChannel as BaseDatabaseChannel;
use Illuminate\Notifications\Notification;

class DatabaseChannel extends BaseDatabaseChannel
{
    protected function buildPayload($notifiable, Notification $notification): array
    {
        $type = method_exists($notification, "databaseType")
            ? $notification->databaseType()
            : $notification::class;

        return [
            "id" => $notification->id,
            "type" => $type,
            "data" => $this->getData($notifiable, $notification),
            "read_at" => null,
        ];
    }
}
