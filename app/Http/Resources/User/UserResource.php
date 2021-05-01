<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
        ];
    }
}
