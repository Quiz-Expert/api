<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "type" => $this->type,
            "data" => $this->data,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "read_at" => $this->read_at,
        ];
    }
}
