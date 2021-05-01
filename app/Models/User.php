<?php

declare(strict_types=1);

namespace Quiz\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    protected $guarded = [];

    protected $hidden = [
        "password",
    ];

    protected $casts = [
        "is_admin" => "boolean",
    ];

    public function suggestions(): HasMany
    {
        return $this->hasMany(Suggestion::class);
    }

    public function mistakes(): HasMany
    {
        return $this->hasMany(Mistake::class);
    }
}
