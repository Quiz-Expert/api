<?php

declare(strict_types=1);

namespace Quiz\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Quiz\Http\Resources\GameInvite\GameInviteResource;
use Quiz\Models\GameInvite;

class UserAccepted implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected GameInvite $gameInvite;

    public function __construct(GameInvite $gameInvite)
    {
        $this->gameInvite = $gameInvite;
    }

    public function broadcastOn(): Channel
    {
        $gameInviteId = $this->gameInvite->id;

        return new PrivateChannel("queue.${gameInviteId}");
    }

    public function broadcastAs(): string
    {
        return "game_invite_accepted";
    }

    public function broadcastWith(): array
    {
        return [
            "invite" => new GameInviteResource($this->gameInvite),
            "userId" => $this->gameInvite->recipient_id,
        ];
    }
}
