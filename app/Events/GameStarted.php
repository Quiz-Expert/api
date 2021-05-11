<?php

declare(strict_types=1);

namespace Quiz\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Quiz\Models\Game;

class GameStarted implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function broadcastOn(): Channel
    {
        $gameId = $this->game->id;

        return new PresenceChannel("game.${gameId}");
    }

    public function broadcastAs(): string
    {
        return "game_started";
    }
}
