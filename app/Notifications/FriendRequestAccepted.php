<?php

declare(strict_types=1);

namespace Quiz\Notifications;

use Illuminate\Notifications\Notification;
use Quiz\Http\Resources\User\UserResource;
use Quiz\Models\User;
use Quiz\Notifications\Channels\BroadcastChannel;
use Quiz\Notifications\Channels\DatabaseChannel;

class FriendRequestAccepted extends Notification
{
    protected const TYPE = "accepted_friend_request";

    protected User $recipient;

    public function __construct(User $recipient)
    {
        $this->recipient = $recipient;
    }

    public function via(): array
    {
        return [DatabaseChannel::class, BroadcastChannel::class];
    }

    public function toArray(): array
    {
        return [
            "data" => new UserResource($this->recipient),
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
