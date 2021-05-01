<?php

declare(strict_types=1);

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\CreatesCategories;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreatesCategories;

    public function testUserCanCreateCategoryWithProperData(): void
    {
        $response = $this->post("categories", [
            "name" => "The name of category",
            "description" => "lorem ipsum",
            "icon" => "8d213da21.png",
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotCreateCategoryWithValidationErrors(): void
    {
        $response = $this->post("categories", [
            "description" => "lorem ipsum",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name", "icon"]);
    }

    public function testUserCannotCreateCategoryWithExistingName(): void
    {
        $existingName = "Existing category";

        $this->createCategory([
            "name" => $existingName,
        ]);

        $response = $this->post("categories", [
            "name" => $existingName,
            "description" => "lorem ipsum",
            "icon" => "8d213da21.png",
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(["name"]);
    }
}
