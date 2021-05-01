<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrentUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "is_admin" => $this->is_admin,
        ];
    }
}
