<?php

declare(strict_types=1);

namespace Quiz\Notifications;

use Illuminate\Notifications\Notification;
use Quiz\Http\Resources\GameInvite\GameInviteResource;
use Quiz\Models\GameInvite;
use Quiz\Notifications\Channels\BroadcastChannel;
use Quiz\Notifications\Channels\DatabaseChannel;

class IncomingGameInvite extends Notification
{
    protected const TYPE = "incoming_game_request";

    protected GameInvite $gameInvite;

    public function __construct(GameInvite $gameInvite)
    {
        $this->gameInvite = $gameInvite;
    }

    public function via(): array
    {
        return [DatabaseChannel::class, BroadcastChannel::class];
    }

    public function toArray(): array
    {
        return [
            "data" => new GameInviteResource($this->gameInvite),
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
