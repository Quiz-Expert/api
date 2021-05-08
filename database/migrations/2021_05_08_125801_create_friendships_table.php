<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendshipsTable extends Migration
{
    public function up(): void
    {
        Schema::create("friendships", function (Blueprint $table) {
            $table->foreignId("user_id")->constrained("users")->onDelete("cascade");
            $table->foreignId("friend_id")->constrained("users")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("friendships");
    }
}
