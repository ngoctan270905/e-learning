<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User; // Cần import User Model để gán user_id
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Tên Model tương ứng với Factory này.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Gán khóa học cho một User ngẫu nhiên (Giảng viên)
            // User::factory() đảm bảo nếu chưa có user nào, nó sẽ tạo một user mới
            'user_id' => User::factory(), 
            
            'title' => $this->faker->catchPhrase() . ' Mastering ' . $this->faker->word(),
            
            'description' => $this->faker->paragraph(3),
        ];
    }
}