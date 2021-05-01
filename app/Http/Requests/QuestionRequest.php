<?php

declare(strict_types=1);

namespace Quiz\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Quiz\Models\Question;

/**
 * @property string $text
 * @property string $answer_a
 * @property string $answer_b
 * @property string $answer_c
 * @property string $answer_d
 * @property string $good_answer
 * @property string $category_id
 */
class QuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "text" => ["required"],
            "answer_a" => ["required"],
            "answer_b" => ["required"],
            "answer_c" => ["required"],
            "answer_d" => ["required"],
            "category_id" => ["required", "exists:categories,id"],
            "good_answer" => ["required", Rule::in(Question::possibleAnswers())],
        ];
    }

    public function getData(): array
    {
        return $this->only("text", "answer_a", "answer_b", "answer_c", "answer_d", "good_answer", "category_id");
    }
}
