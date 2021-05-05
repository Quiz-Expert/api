<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Notification;

use Quiz\Http\Resources\PaginatedCollection;

class NotificationCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
