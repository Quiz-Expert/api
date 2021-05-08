<?php

declare(strict_types=1);

namespace Quiz\Notifications;

use Illuminate\Notifications\Notification;
use Quiz\Http\Resources\FriendRequest\IncomingFriendRequest as IncomingFriendRequestResource;
use Quiz\Models\FriendRequest;
use Quiz\Notifications\Channels\BroadcastChannel;
use Quiz\Notifications\Channels\DatabaseChannel;

class IncomingFriendRequest extends Notification
{
    protected const TYPE = "incoming_friend_request";

    protected FriendRequest $friendRequest;

    public function __construct(FriendRequest $friendRequest)
    {
        $this->friendRequest = $friendRequest;
    }

    public function via(): array
    {
        return [DatabaseChannel::class, BroadcastChannel::class];
    }

    public function toArray(): array
    {
        return [
            "data" => new IncomingFriendRequestResource($this->friendRequest),
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
