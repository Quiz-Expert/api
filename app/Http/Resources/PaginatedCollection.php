<?php

declare(strict_types=1);

namespace Quiz\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedCollection extends ResourceCollection
{
    protected function paginationData(): array
    {
        return [
            "total" => $this->total(),
            "count" => $this->count(),
            "per_page" => $this->perPage(),
            "current_page" => $this->currentPage(),
            "total_pages" => $this->lastPage(),
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return JsonResource::toResponse($request);
    }
}
