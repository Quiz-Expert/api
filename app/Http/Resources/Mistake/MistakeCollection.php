<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Mistake;

use Quiz\Http\Resources\PaginatedCollection;

class MistakeCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
