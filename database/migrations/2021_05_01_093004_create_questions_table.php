<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up(): void
    {
        Schema::create("questions", function (Blueprint $table): void {
            $table->id();
            $table->text("text");
            $table->foreignId("category_id")->constrained()->onDelete("restrict");
            $table->string("answer_a");
            $table->string("answer_b");
            $table->string("answer_c");
            $table->string("answer_d");
            $table->string("good_answer");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("questions");
    }
}
