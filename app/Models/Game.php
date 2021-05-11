<?php

declare(strict_types=1);

namespace Quiz\Models;

use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Quiz\Domain\State;

/**
 * @property int $id
 * @property ArrayObject $category
 * @property Collection $questions
 * @property Collection $users
 * @property State $state
 * @property bool $is_active
 */
class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "state" => State::class,
        "users" => AsCollection::class,
        "questions" => AsCollection::class,
        "category" => AsArrayObject::class,
        "is_active" => "boolean",
        "is_draw" => "boolean",
    ];

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getPlayersCount(): int
    {
        return $this->users->count();
    }

    public function getTurnsCount(): int
    {
        return $this->questions->count();
    }

    public function finish(): void
    {
        $this->is_active = false;
        $this->save();
    }
}
