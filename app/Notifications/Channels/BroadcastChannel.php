<?php

declare(strict_types=1);

namespace Quiz\Notifications\Channels;

use Illuminate\Notifications\Channels\BroadcastChannel as BaseBroadcastChannel;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Quiz\Notifications\Events\BroadcastNotificationCreated;

class BroadcastChannel extends BaseBroadcastChannel
{
    public function send($notifiable, Notification $notification): ?array
    {
        $message = $this->getData($notifiable, $notification);

        $event = new BroadcastNotificationCreated(
            $notifiable,
            $notification,
            is_array($message) ? $message : $message->data
        );

        if ($message instanceof BroadcastMessage) {
            $event->onConnection($message->connection)
                ->onQueue($message->queue);
        }

        return $this->events->dispatch($event);
    }
}
