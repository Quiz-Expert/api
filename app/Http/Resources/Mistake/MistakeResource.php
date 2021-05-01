<?php

declare(strict_types=1);

namespace Quiz\Http\Resources\Mistake;

use Illuminate\Http\Resources\Json\JsonResource;
use Quiz\Http\Resources\Question\QuestionResource;
use Quiz\Http\Resources\User\UserResource;

class MistakeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "text" => $this->text,
            "is_active" => $this->is_active,
            "question" => new QuestionResource($this->whenLoaded("question")),
            "user" => new UserResource($this->whenLoaded("user")),
        ];
    }
}
