<?php

declare(strict_types=1);

use Illuminate\Support\Str;

$prefix = Str::slug(env("APP_NAME", "laravel"), "_") . "_cache";

return [
    "default" => env("CACHE_DRIVER", "file"),
    "stores" => [
        "array" => [
            "driver" => "array",
            "serialize" => false,
        ],
        "file" => [
            "driver" => "file",
            "path" => storage_path("framework/cache/data"),
        ],
    ],
    "prefix" => env("CACHE_PREFIX", $prefix),
];
