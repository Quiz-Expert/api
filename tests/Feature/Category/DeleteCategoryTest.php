<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreatesCategories;
use Tests\Traits\CreatesUsers;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;
    use CreatesUsers;

    public function testUserCanDeleteCategory(): void
    {
        Sanctum::actingAs($this->createUser());

        $category = $this->createCategory();

        $response = $this->delete("categories/{$category->id}");

        $response->assertSuccessful();
    }

    public function testUserCannotDeleteCategoryIfItDoesntExist(): void
    {
        Sanctum::actingAs($this->createUser());

        $nonExistingId = 1234;

        $response = $this->delete("categories/${nonExistingId}");

        $response->assertNotFound();
    }
}
