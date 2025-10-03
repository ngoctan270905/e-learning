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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // 1. Khóa ngoại liên kết với User (người bình luận)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Nội dung bình luận
            $table->text('content');

            // 3. Quan hệ Polymorphic (Tạo 2 cột: commentable_id & commentable_type)
            $table->morphs('commentable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
