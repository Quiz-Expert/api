<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesCategories;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;

    public function testUserCanDeleteCategory(): void
    {
        $category = $this->createCategory();

        $response = $this->delete("categories/{$category->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotDeleteCategoryIfItDoesntExist(): void
    {
        $nonExistingId = 1234;

        $response = $this->delete("categories/${nonExistingId}");

        $response->assertNotFound();
    }
}
