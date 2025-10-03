<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Quan hệ Many-to-Many: Tag có nhiều (belongs to many) Lesson.
     * Pivot table: lesson_tag.
     */
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)
                    ->withTimestamps(); // Bao gồm created_at trong pivot table
    }
}