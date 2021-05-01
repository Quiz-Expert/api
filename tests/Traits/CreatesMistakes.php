<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Support\Collection;
use Quiz\Models\Category;
use Quiz\Models\Mistake;
use Quiz\Models\Question;
use Quiz\Models\User;

trait CreatesMistakes
{
    public function createMistake(array $data = [], ?User $user = null, ?Question $question = null): Mistake
    {
        if ($question === null) {
            $question = Question::factory()->for(Category::factory());
        }

        if ($user === null) {
            $user = User::factory();
        }

        return Mistake::factory($data)
            ->for($question)
            ->for($user)
            ->create();
    }

    public function createMistakes(int $count, ?User $user = null, ?Question $question = null): Collection
    {
        if ($question === null) {
            $question = Question::factory()->for(Category::factory());
        }

        if ($user === null) {
            $user = User::factory();
        }

        return Mistake::factory($count)
            ->for($question)
            ->for($user)
            ->create();
    }
}
