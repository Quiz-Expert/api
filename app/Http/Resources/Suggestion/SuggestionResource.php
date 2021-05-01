<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Suggestion;

use Illuminate\Http\Resources\Json\JsonResource;
use Quiz\Http\Resources\Category\CategoryResource;
use Quiz\Http\Resources\User\UserResource;

class SuggestionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "text" => $this->text,
            "answer_a" => $this->answer_a,
            "answer_b" => $this->answer_b,
            "answer_c" => $this->answer_c,
            "answer_d" => $this->answer_d,
            "good_answer" => $this->good_answer,
            "status" => $this->status,
            "category" => new CategoryResource($this->whenLoaded("category")),
            "user" => new UserResource($this->whenLoaded("user")),
        ];
    }
}
