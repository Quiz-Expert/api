<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Quiz\Events\UserAccepted;
use Quiz\Events\UserRejected;
use Quiz\Exceptions\GameException;
use Quiz\Helpers\GameEngine;
use Quiz\Http\Requests\StoreGameInvite;
use Quiz\Http\Resources\Game\GameResource;
use Quiz\Http\Resources\GameInvite\GameInviteResource;
use Quiz\Models\GameInvite;
use Quiz\Models\User;
use Quiz\Notifications\IncomingGameInvite;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class GameInviteController extends Controller
{
    public function incoming(): ResourceCollection
    {
        $invites = GameInvite::query()
            ->with(["sender", "category"])
            ->get();

        return GameInviteResource::collection($invites);
    }

    public function store(StoreGameInvite $request): Response
    {
        /** @var User $invitedUser */
        $invitedUser = User::query()->find($request->user_id);

        /** @var GameInvite $invite */
        $invite = GameInvite::query()->create([
            "sender_id" => $request->user()->id,
            "recipient_id" => $invitedUser->id,
            "category_id" => $request->category_id,
        ]);

        $invitedUser->notify(new IncomingGameInvite($invite));

        return response()->noContent();
    }

    /**
     * @throws GameException
     */
    public function accept(Request $request, GameInvite $gameInvite, GameEngine $gameEngine): GameResource
    {
        $user = $request->user();

        if (!$gameInvite->recipient->is($user)) {
            abort(SymfonyResponse::HTTP_NOT_FOUND);
        }

        $users = collect([$gameInvite->sender, $gameInvite->recipient]);
        $game = $gameEngine->createGame($gameInvite->category, $users);

        event(new UserAccepted($gameInvite));

        $gameInvite->delete();

        return new GameResource($game);
    }

    public function reject(Request $request, GameInvite $gameInvite): Response
    {
        $user = $request->user();

        if (!$gameInvite->recipient->is($user)) {
            abort(SymfonyResponse::HTTP_NOT_FOUND);
        }

        $gameInvite->delete();

        event(new UserRejected($gameInvite));

        return response()->noContent();
    }

    public function cancel(Request $request, GameInvite $gameInvite): Response
    {
        $user = $request->user();

        if (!$gameInvite->sender->is($user)) {
            abort(SymfonyResponse::HTTP_NOT_FOUND);
        }

        $gameInvite->delete();

        return response()->noContent();
    }
}
