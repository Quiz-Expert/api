<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Quiz\Models\Question;
use Quiz\Models\Suggestion;

class SuggestionFactory extends Factory
{
    protected $model = Suggestion::class;

    public function definition(): array
    {
        return [
            "text" => $this->faker->paragraph,
            "answer_a" => $this->faker->sentence,
            "answer_b" => $this->faker->sentence,
            "answer_c" => $this->faker->sentence,
            "answer_d" => $this->faker->sentence,
            "status" => Suggestion::STATUS_PENDING,
            "good_answer" => $this->faker->randomElement(Question::possibleAnswers()),
        ];
    }
}
