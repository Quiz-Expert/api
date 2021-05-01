<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Quiz\Models\Category;
use Quiz\Models\Question;
use Quiz\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)
            ->create();

        Category::factory(24)
            ->has(Question::factory(24))
            ->create();
    }
}
