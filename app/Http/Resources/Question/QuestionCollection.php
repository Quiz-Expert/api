<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Question;

use Quiz\Http\Resources\PaginatedCollection;

class QuestionCollection extends PaginatedCollection
{
    public function toArray($request): array
    {
        return [
            "data" => $this->collection,
            "pagination" => $this->paginationData(),
        ];
    }
}
