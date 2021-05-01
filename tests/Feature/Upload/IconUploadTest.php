<?php

declare(strict_types=1);

namespace Tests\Feature\Upload;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Quiz\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use Tests\CreatesUsers;
use Tests\TestCase;

class IconUploadTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function testUserCanUploadIcon(): void
    {
        Storage::fake(Category::UPLOAD_DIRECTORY);

        $file = UploadedFile::fake()->create("avatar.jpg");

        $response = $this->post("upload/icons", [
            "file" => $file,
        ]);

        $response->assertSuccessful();
    }

    public function testUserCannotUploadNonImageFile(): void
    {
        Storage::fake(Category::UPLOAD_DIRECTORY);

        $file = UploadedFile::fake()->create("avatar.pdf");

        $response = $this->post("upload/icons", [
            "file" => $file,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors("file");
    }
}
