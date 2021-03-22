<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Quiz\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "email_verified_at" => now(),
            "password" => $this->hasher()->make("secret123"),
        ];
    }

    public function unverified(): self
    {
        return $this->state(fn (): array => [
            "email_verified_at" => null,
        ]);
    }

    protected function hasher(): Hasher
    {
        return app()->make(Hasher::class);
    }
}
