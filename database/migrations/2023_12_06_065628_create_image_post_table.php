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
        Schema::create('image_post', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('post_id');

            $table->index('post_id', 'image_post_post_idx');
            $table->index('image_id', 'image_post_image_idx');

            $table->foreign('post_id', 'image_post_post_fk')
                ->references('id')
                ->on('posts');
            $table->foreign('image_id', 'image_post_image_fk')
                ->references('id')
                ->on('images');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_post');
    }
};
