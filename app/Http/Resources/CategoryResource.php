<?php

declare(strict_types=1);

namespace Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "icon" => $this->icon_url,
        ];
    }
}
