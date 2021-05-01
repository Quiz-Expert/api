<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Quiz\Models\Category;
use Quiz\Models\Question;
use Quiz\Models\Suggestion;
use Quiz\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)
            ->create();

        $categories = Category::factory(24)
            ->has(Question::factory(24))
            ->create();

        Suggestion::factory(30)
            ->state(new Sequence(fn () => [
                "user_id" => $users->random(),
            ]))
            ->state(new Sequence(fn () => [
                "category_id" => $categories->random(),
            ]))
            ->create();
    }
}
