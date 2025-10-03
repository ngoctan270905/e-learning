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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại liên kết với bảng users
            // Sử dụng constrained() để tạo FK và index, và onDelete('cascade') để xóa profile khi user bị xóa
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

            // Các cột thông tin mở rộng
            $table->text('bio')->nullable();
            $table->date('birthday')->nullable();
            $table->string('avatar_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
