<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Support\Collection;
use Quiz\Models\Category;

trait CreatesCategories
{
    public function createCategory(array $data = []): Category
    {
        return Category::factory($data)->create();
    }

    public function createCategories(int $count): Collection
    {
        return Category::factory($count)->create();
    }
}
