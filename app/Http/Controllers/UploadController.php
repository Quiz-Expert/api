<?php

declare(strict_types=1);

namespace Quiz\Http\Controllers;

use Quiz\Http\Requests\UploadRequest;
use Quiz\Models\Category;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadController extends Controller
{
    public function storeIcon(UploadRequest $request): JsonResponse
    {
        $file = $request->file("file");

        $path = $file->store(Category::UPLOAD_DIRECTORY);

        return response()->json([
            "data" => [
                "filename" => $file->hashName(),
                "url" => asset($path),
            ],
        ]);
    }
}
