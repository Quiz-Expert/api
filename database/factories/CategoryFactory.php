<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Quiz\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            "name" => $this->faker->sentence,
            "description" => $this->faker->paragraph,
            "icon" => md5(Str::random(20)) . ".png",
        ];
    }
}
