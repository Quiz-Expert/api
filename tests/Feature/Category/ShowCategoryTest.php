<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesUsers;

class ShowCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;
    use CreatesUsers;

    public function testUserCanShowCategory(): void
    {
        Sanctum::actingAs($this->createUser());

        $category = $this->createCategory();

        $response = $this->get("categories/{$category->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotShowNonExistingCategory(): void
    {
        Sanctum::actingAs($this->createUser());

        $nonExistingId = 1234;

        $response = $this->get("categories/${nonExistingId}");

        $response->assertNotFound();
    }
}
