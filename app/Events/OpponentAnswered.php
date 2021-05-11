<?php

declare(strict_types=1);

namespace Quiz\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Quiz\Domain\Answer;
use Quiz\Models\Game;

class OpponentAnswered implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    protected Game $game;
    protected Answer $answer;

    public function __construct(Game $game, Answer $answer)
    {
        $this->game = $game;
        $this->answer = $answer;
    }

    public function broadcastOn(): Channel
    {
        $gameId = $this->game->id;

        return new PresenceChannel("game.${gameId}");
    }

    public function broadcastAs(): string
    {
        return "opponent_answered";
    }

    public function broadcastWith(): array
    {
        return [
            "answer" => $this->answer->toArray(),
        ];
    }
}
