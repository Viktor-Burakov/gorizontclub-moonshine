<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('active')->default(0);
            $table->string('url')->nullable()->unique();
            $table->string('title')->nullable();
            $table->string('h1')->nullable();
            $table->string('description')->nullable();
            $table->dateTime('date_start', $precision = 0)->nullable();
            $table->dateTime('date_end', $precision = 0)->nullable();
            $table->string('preview')->nullable();
            $table->string('preview_alt')->nullable();
            $table->text('preview_text')->nullable();
            $table->mediumText('content')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
