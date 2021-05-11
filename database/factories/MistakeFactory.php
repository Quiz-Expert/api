<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Quiz\Models\Mistake;

class MistakeFactory extends Factory
{
    protected $model = Mistake::class;

    public function definition(): array
    {
        return [
            "text" => $this->faker->paragraph,
            "is_active" => true,
        ];
    }
}
