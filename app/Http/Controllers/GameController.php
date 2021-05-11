<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Quiz\Helpers\GameEngine;
use Quiz\Models\Game;

class GameController extends Controller
{
    public function answer(Game $game, Request $request, GameEngine $gameEngine): JsonResponse
    {
        $answer = $gameEngine->checkUserAnswer($game, $request->user(), $request->get("answer"));

        $gameEngine->saveAnwser($game, $answer);

        if ($gameEngine->checkIfAllPlayersAnswered($game)) {
            $gameEngine->nextTurn($game);
        }

        if ($gameEngine->checkIfGameIsShouldBeFinished($game)) {
            $gameEngine->endGame($game);
        }

        return response()->json([
            "data" => $answer->toArray(),
        ]);
    }
}
