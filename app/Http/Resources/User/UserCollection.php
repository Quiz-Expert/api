<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\User;

use Quiz\Http\Resources\PaginatedCollection;

class UserCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
