<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Category;

use Quiz\Http\Resources\PaginatedCollection;

class CategoryCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
