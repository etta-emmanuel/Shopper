<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable');
            $table->string('img_url');
            $table->string('alt_text')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
