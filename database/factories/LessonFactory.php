<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Course; // Cần import Course Model để gán course_id
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Tên Model tương ứng với Factory này.
     *
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Gán bài học cho một Course ngẫu nhiên
            // Course::factory() đảm bảo tạo Course mới nếu không được cung cấp course_id
            'course_id' => Course::factory(), 
            
            'title' => 'Bài học số ' . $this->faker->numberBetween(1, 20) . ': ' . $this->faker->sentence(3),
            
            'content' => $this->faker->paragraphs(5, true), // Tạo nội dung dài 5 đoạn văn
        ];
    }
}