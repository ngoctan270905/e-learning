<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'content', 
        'commentable_id', // Cần thiết cho Mass Assignment nếu tạo thủ công
        'commentable_type', // Cần thiết cho Mass Assignment nếu tạo thủ công
    ];

    /**
     * Quan hệ Polymorphic (Đa hình): Comment thuộc về (morph to) Course HOẶC Lesson.
     * Eloquent sẽ tự động tìm đối tượng dựa vào commentable_id và commentable_type.
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Quan hệ One-to-Many: Comment thuộc về (belongs to) một User (Người bình luận).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}