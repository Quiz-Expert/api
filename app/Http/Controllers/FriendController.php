<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Quiz\Http\Requests\StoreFriendRequest;
use Quiz\Http\Resources\FriendRequest\GameInviteResource;
use Quiz\Http\Resources\FriendRequest\SentFriendRequest;
use Quiz\Http\Resources\User\UserCollection;
use Quiz\Models\User;
use Quiz\Notifications\FriendRequestAccepted;
use Quiz\Notifications\IncomingFriendRequest as IncomingFriendRequestNotification;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class FriendController extends Controller
{
    public function friends(Request $request): ResourceCollection
    {
        $friends = $request->user()
            ->friends()
            ->paginate();

        return new UserCollection($friends);
    }

    public function sentFriendRequests(Request $request): ResourceCollection
    {
        $sentFriendRequests = $request->user()->sentFriendRequests;

        return SentFriendRequest::collection($sentFriendRequests);
    }

    public function incomingFriendRequests(Request $request): ResourceCollection
    {
        $incomingFriendRequests = $request->user()->incomingFriendRequests;

        return GameInviteResource::collection($incomingFriendRequests);
    }

    public function createFriendRequest(StoreFriendRequest $request): Response
    {
        $friend = User::query()->find($request->user_id);

        $user = $request->user();

        if ($user->alreadySentFriendRequestTo($friend)) {
            abort(SymfonyResponse::HTTP_BAD_REQUEST, "You have already sent request");
        }

        $friendRequest = $user->sendFriendRequest($friend);

        $friend->notify(new IncomingFriendRequestNotification($friendRequest));

        return response()->noContent();
    }

    public function unfriend(Request $request, User $friend): Response
    {
        $request->user()->unfriend($friend);

        return response()->noContent();
    }

    public function acceptFriendRequest(Request $request, int $friendRequestId): Response
    {
        $user = $request->user();

        if (!$user->hasIncomingFriendRequest($friendRequestId)) {
            abort(SymfonyResponse::HTTP_NOT_FOUND, "No friend request found");
        }

        $sender = $user->acceptFriendRequest($friendRequestId);

        $sender->notify(new FriendRequestAccepted($user));

        return response()->noContent();
    }

    public function rejectFriendRequest(Request $request, int $friendRequestId): Response
    {
        $user = $request->user();

        if (!$user->hasIncomingFriendRequest($friendRequestId)) {
            abort(SymfonyResponse::HTTP_NOT_FOUND, "No friend request found");
        }

        $user->rejectFriendRequest($friendRequestId);

        return response()->noContent();
    }

    public function cancelFriendRequest(Request $request, int $friendRequestId): Response
    {
        $user = $request->user();

        if (!$user->hasSentFriendRequest($friendRequestId)) {
            abort(SymfonyResponse::HTTP_NOT_FOUND, "No friend request found");
        }

        $user->cancelFriendRequest($friendRequestId);

        return response()->noContent();
    }
}
