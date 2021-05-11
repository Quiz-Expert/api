<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Game;

use Illuminate\Http\Resources\Json\JsonResource;
use Quiz\Http\Resources\User\UserResource;
use Quiz\Models\User;

class GameResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "users" => UserResource::collection(User::query()->findMany($this->users)),
            "is_active" => $this->is_active,
            "category" => $this->category,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
