<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create("categories", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->string("icon");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("categories");
    }
}
