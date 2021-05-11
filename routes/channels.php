<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Broadcast;
use Quiz\Models\Game;
use Quiz\Models\GameInvite;
use Quiz\Models\User;

Broadcast::channel("notifications.{userId}", function (User $user, int $userId) {
    return $user->id === $userId;
});

Broadcast::channel("queue.{gameInviteId}", function (User $user, int $gameInviteId) {
    /** @var GameInvite $gameInvite */
    $gameInvite = GameInvite::query()->findorFail($gameInviteId);

    return $user->id === $gameInvite->sender_id;
});

Broadcast::channel("queue.{gameInviteId}", function (User $user, int $gameInviteId) {
    /** @var GameInvite $gameInvite */
    $gameInvite = GameInvite::query()->findorFail($gameInviteId);

    return $user->id === $gameInvite->sender_id;
});

Broadcast::channel("game.{gameId}", function (User $user, int $gameId) {
    /** @var Game $game */
    $game = Game::query()->findorFail($gameId);

    if ($game->users->contains($user->id)) {
        return [
            "id" => $user->id,
            "name" => $user->name,
        ];
    }
});
