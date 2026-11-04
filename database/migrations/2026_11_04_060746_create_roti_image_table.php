<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('menu_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roti_id')->constrained('roti')->cascadeOnDelete();
            $table->string('image_path');
            $table->string('thumbnail_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('menu_images');
    }
};