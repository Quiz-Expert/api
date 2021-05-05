<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Broadcast;
use Quiz\Models\User;

Broadcast::channel("notifications.{userId}", function (User $user, int $userId) {
    return $user->id === $userId;
});
