<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Tên Model tương ứng với Factory này.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Người bình luận (luôn là một User)
            'user_id' => User::factory(), 
            
            'content' => $this->faker->paragraph(2),
            
            // Cột Polymorphic MẶC ĐỊNH
            // Factory này không tự tạo commentable_id/type, mà thường được tạo
            // thông qua quan hệ MorphMany trong Seeder.
            // Tuy nhiên, ta đặt giá trị null hoặc mặc định để tránh lỗi khi gọi độc lập.
            'commentable_id' => null, 
            'commentable_type' => null, 
        ];
    }
    
    // --- States Tùy chỉnh cho Quan hệ Polymorphic ---

    /**
     * State để tạo comment cho Course.
     */
    public function forCourse(\App\Models\Course|int $course): Factory
    {
        $courseId = $course instanceof \App\Models\Course ? $course->id : $course;
        
        return $this->state(fn (array $attributes) => [
            'commentable_id' => $courseId,
            'commentable_type' => Course::class,
        ]);
    }
    
    /**
     * State để tạo comment cho Lesson.
     */
    public function forLesson(\App\Models\Lesson|int $lesson): Factory
    {
        $lessonId = $lesson instanceof \App\Models\Lesson ? $lesson->id : $lesson;

        return $this->state(fn (array $attributes) => [
            'commentable_id' => $lessonId,
            'commentable_type' => Lesson::class,
        ]);
    }
}