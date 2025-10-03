<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'course_id'];

    /**
     * Quan hệ One-to-Many: Lesson thuộc về (belongs to) một Course.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Quan hệ Many-to-Many: Lesson có nhiều (belongs to many) Tag.
     * Pivot table: lesson_tag.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
                    ->withTimestamps(); // Bao gồm created_at trong pivot table
    }

    /**
     * Quan hệ Polymorphic: Lesson có nhiều (morph many) Comment.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}