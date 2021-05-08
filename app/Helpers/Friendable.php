<?php

declare(strict_types=1);

namespace Quiz\Helpers;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Quiz\Models\FriendRequest;
use Quiz\Models\User;

trait Friendable
{
    public function unfriend(User $user): void
    {
        $this->friends()->detach($user->id);
        $user->friends()->detach($this->id);
    }

    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "friendships", "user_id", "friend_id");
    }

    public function sendFriendRequest(User $user): FriendRequest
    {
        /** @var FriendRequest $friendRequest */
        $friendRequest = $this->sentFriendRequests()->create([
            "recipient_id" => $user->id,
        ]);

        return $friendRequest;
    }

    public function sentFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, "sender_id", "id");
    }

    public function acceptFriendRequest(int $friendRequestId): User
    {
        /** @var FriendRequest $friendRequest */
        $friendRequest = $this->incomingFriendRequests()->find($friendRequestId);
        $sender = $friendRequest->sender;

        $this->befriend($sender);
        $friendRequest->delete();

        return $sender;
    }

    public function incomingFriendRequests(): HasMany
    {
        return $this->hasMany(FriendRequest::class, "recipient_id", "id");
    }

    public function befriend(User $user): void
    {
        $this->friends()->attach($user->id);
        $user->friends()->attach($this->id);
    }

    public function rejectFriendRequest(int $friendRequestId): User
    {
        /** @var FriendRequest $friendRequest */
        $friendRequest = $this->incomingFriendRequests()->find($friendRequestId);
        $sender = $friendRequest->sender;

        $friendRequest->delete();
        return $sender;
    }

    public function cancelFriendRequest(int $friendRequestId): void
    {
        $this->sentFriendRequests()->find($friendRequestId)->delete();
    }

    public function hasIncomingFriendRequest(int $friendRequestId): bool
    {
        return $this->incomingFriendRequests()
            ->where("id", $friendRequestId)
            ->exists();
    }

    public function hasSentFriendRequest(int $friendRequestId): bool
    {
        return $this->sentFriendRequests()
            ->where("id", $friendRequestId)
            ->exists();
    }

    public function alreadySentFriendRequestTo(User $friend): bool
    {
        return $this->sentFriendRequests()
            ->where("recipient_id", $friend->id)
            ->exists();
    }
}
