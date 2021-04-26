<?php

declare(strict_types=1);

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

return [
    "stateful" => "localhost",
    "expiration" => null,
    "middleware" => [
        "verify_csrf_token" => VerifyCsrfToken::class,
        "encrypt_cookies" => EncryptCookies::class,
    ],
];
