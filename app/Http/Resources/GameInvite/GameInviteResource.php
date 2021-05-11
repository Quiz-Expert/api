<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\GameInvite;

use Illuminate\Http\Resources\Json\JsonResource;
use Quiz\Http\Resources\Category\CategoryResource;
use Quiz\Http\Resources\User\UserResource;

class GameInviteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "user" => new UserResource($this->sender),
            "category" => new CategoryResource($this->category),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
