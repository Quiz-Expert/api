<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Collection;
use Quiz\Models\Category;
use Quiz\Models\Question;

trait CreatesQuestions
{
    public function createQuestion(array $data = [], ?Category $category = null): Question
    {
        if ($category === null) {
            return Question::factory($data)
                ->for(Category::factory())
                ->create();
        }

        return Question::factory($data)
            ->create();
    }

    public function createQuestions(int $count, ?Category $category = null): Collection
    {
        if ($category === null) {
            return Question::factory($count)
                ->for(Category::factory())
                ->create();
        }

        return Question::factory($count)
            ->for($category)
            ->create();
    }
}
