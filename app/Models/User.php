<?php

declare(strict_types=1);

namespace Quiz\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string|null $avatar
 * @property string $password
 * @property bool $is_admin
 */
class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;

    protected $fillable = [
        "name",
        "email",
        "avatar",
        "password",
        "is_admin",
    ];

    protected $hidden = [
        "password",
    ];

    protected $casts = [
        "is_admin" => "boolean",
    ];
}
