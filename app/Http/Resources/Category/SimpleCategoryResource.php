<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
        ];
    }
}
