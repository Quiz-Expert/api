<?php

declare(strict_types=1);

namespace Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            "category" => new CategoryResource($this->whenLoaded("category")),
        ];
    }
}
