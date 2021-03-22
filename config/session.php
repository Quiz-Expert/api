<?php

declare(strict_types=1);

use Illuminate\Support\Str;

$default = Str::slug(env("APP_NAME", "laravel"), "_") . "_session";

return [
    "driver" => env("SESSION_DRIVER", "file"),
    "lifetime" => env("SESSION_LIFETIME", 120),
    "expire_on_close" => false,
    "encrypt" => false,
    "files" => storage_path("framework/sessions"),
    "connection" => env("SESSION_CONNECTION"),
    "table" => "sessions",
    "store" => env("SESSION_STORE"),
    "lottery" => [2, 100],
    "cookie" => env("SESSION_COOKIE", $default),
    "path" => "/",
    "domain" => env("SESSION_DOMAIN"),
    "secure" => env("SESSION_SECURE_COOKIE"),
    "http_only" => true,
    "same_site" => "lax",
];
