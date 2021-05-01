<?php

declare(strict_types=1);

namespace Quiz\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $text
 * @property string $question_id
 */
class MistakeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "text" => ["required"],
            "question_id" => ["required", "exists:questions,id"],
        ];
    }

    public function getData(): array
    {
        return $this->only("text", "question_id");
    }
}
