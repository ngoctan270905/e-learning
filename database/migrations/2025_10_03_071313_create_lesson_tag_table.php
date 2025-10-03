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
        // Tên bảng phải theo quy ước số ít (lesson_tag) và thứ tự bảng chữ cái
        Schema::create('lesson_tag', function (Blueprint $table) {
            
            // Khóa ngoại 1
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            
            // Khóa ngoại 2
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            
            // Khóa chính kép (đảm bảo cặp lesson_id/tag_id là duy nhất)
            $table->primary(['lesson_id', 'tag_id']); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_tag');
    }
};
