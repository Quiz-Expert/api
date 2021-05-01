<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesCategories;
use Tests\TestCase;

class ShowCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;

    public function testUserCanShowCategory(): void
    {
        $category = $this->createCategory();

        $response = $this->get("categories/{$category->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotShowNonExistingCategory(): void
    {
        $nonExistingId = 1234;

        $response = $this->get("categories/${nonExistingId}");

        $response->assertNotFound();
    }
}
