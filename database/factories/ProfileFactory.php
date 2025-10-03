<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Tên Model tương ứng với Factory này.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // user_id sẽ được Eloquent tự động điền khi tạo qua quan hệ
            'bio' => $this->faker->sentence(10),
            'birthday' => $this->faker->date(),
            'avatar_url' => $this->faker->imageUrl(640, 480, 'people', true, 'avatar'),
        ];
    }
}