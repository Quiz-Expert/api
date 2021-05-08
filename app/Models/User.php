<?php

declare(strict_types=1);

namespace Quiz\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Quiz\Helpers\Friendable;

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
    use Friendable;

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

    public function receivesBroadcastNotificationsOn(): string
    {
        return "notifications.{$this->id}";
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where("name", "LIKE", "%{$search}%")
            ->orWhere("email", "LIKE", "%{$search}%");
    }
}
