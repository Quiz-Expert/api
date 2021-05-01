<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\CreatesCategories;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;

    public function testUserCanUpdateCategoryWithProperData(): void
    {
        $category = $this->createCategory();

        $response = $this->put("categories/{$category->id}", [
            "name" => "The name of category",
            "description" => "lorem ipsum",
            "icon" => "8d213da21.png",
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotUpdateCategoryIfItDoesntExist(): void
    {
        $nonExistingId = 1234;

        $response = $this->put("categories/${nonExistingId}", [
            "name" => "The name of category",
            "description" => "lorem ipsum",
            "icon" => "8d213da21.png",
        ]);

        $response->assertNotFound();
    }

    public function testUserCannotUpdateCategoryWithValidationErrors(): void
    {
        $category = $this->createCategory();

        $response = $this->put("categories/{$category->id}", [
            "description" => "lorem ipsum",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name", "icon"]);
    }
}
