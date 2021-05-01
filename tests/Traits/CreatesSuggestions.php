<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Support\Collection;
use Quiz\Models\Category;
use Quiz\Models\Suggestion;
use Quiz\Models\User;

trait CreatesSuggestions
{
    public function createSuggestion(array $data = [], ?User $user = null, ?Category $category = null): Suggestion
    {
        if ($category === null) {
            $category = Category::factory();
        }

        if ($user === null) {
            $user = User::factory();
        }

        return Suggestion::factory($data)
            ->for($category)
            ->for($user)
            ->create();
    }

    public function createSuggestions(int $count, ?User $user = null, ?Category $category = null, array $data = []): Collection
    {
        if ($category === null) {
            $category = Category::factory();
        }

        if ($user === null) {
            $user = User::factory();
        }

        return Suggestion::factory($count, $data)
            ->for($category)
            ->for($user)
            ->create();
    }
}
