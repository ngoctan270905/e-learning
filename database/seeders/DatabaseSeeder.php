<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Xóa code mặc định và thay bằng lời gọi đến DemoSeeder
        $this->call([
            DemoSeeder::class, // Gọi seeder chứa logic tạo User, Course, Lesson, Tag, Comment...
        ]);
    }
}
