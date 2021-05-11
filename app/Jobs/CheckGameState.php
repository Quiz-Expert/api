<?php

declare(strict_types=1);

namespace Quiz\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Quiz\Helpers\GameEngine;
use Quiz\Models\Game;

class CheckGameState implements ShouldQueue
{
    use Dispatchable;
    use SerializesModels;

    protected GameEngine $gameEngine;
    protected Game $game;

    public function __construct(Game $game)
    {
        $this->gameEngine = app(GameEngine::class);
        $this->game = $game;
    }

    public function handle()
    {
        if ($this->gameEngine->checkIfAllPlayersAnswered($this->game)) {
            $this->gameEngine->nextTurn($this->game);
        }

        if ($this->gameEngine->checkIfGameIsShouldBeFinished($this->game)) {
            $this->gameEngine->endGame($this->game);
        }
    }
}
