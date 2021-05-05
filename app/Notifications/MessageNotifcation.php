<?php

declare(strict_types=1);

namespace Quiz\Notifications;

use Illuminate\Notifications\Notification;
use Quiz\Notifications\Channels\BroadcastChannel;
use Quiz\Notifications\Channels\DatabaseChannel;

class MessageNotifcation extends Notification
{
    protected const TYPE = "message";
    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function via(): array
    {
        return [DatabaseChannel::class, BroadcastChannel::class];
    }

    public function toArray(): array
    {
        return [
            "message" => $this->message,
        ];
    }

    public function databaseType(): string
    {
        return static::TYPE;
    }

    public function broadcastType(): string
    {
        return static::TYPE;
    }
}
