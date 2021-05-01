<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Suggestion;

use Quiz\Http\Resources\PaginatedCollection;

class SuggestionCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
