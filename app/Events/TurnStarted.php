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

class TurnStarted implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected Game $game;
    protected array $question;

    public function __construct(Game $game, array $question)
    {
        $this->game = $game;
        $this->question = $question;
    }

    public function broadcastOn(): Channel
    {
        $gameId = $this->game->id;

        return new PresenceChannel("game.${gameId}");
    }

    public function broadcastAs(): string
    {
        return "turn_started";
    }

    public function broadcastWith(): array
    {
        return [
            "question" => $this->question,
        ];
    }
}
