<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\FriendRequest;

use Illuminate\Http\Resources\Json\JsonResource;
use Quiz\Http\Resources\User\UserResource;

class SentFriendRequest extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "user" => new UserResource($this->recipient),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
