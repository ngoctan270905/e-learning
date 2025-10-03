<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Tag;
use App\Models\Comment;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo 5 người dùng, 3 người đầu tiên đóng vai trò giảng viên
        // UserFactory đã được cấu hình để tự động tạo Profile
        $users = User::factory(5)->create();
        $instructors = $users->take(3); // 3 giảng viên
        $students = $users->skip(3); // 2 học viên (người comment)
        
        // 2. Tạo các Tag cố định cần thiết cho truy vấn (Laravel, Performance)
        $tagsData = [
            'Laravel', 'Eloquent', 'Performance', 'Testing', 'PHP'
        ];
        foreach ($tagsData as $tagName) {
            Tag::firstOrCreate(['name' => $tagName]);
        }
        $allTags = Tag::all();
        
        // 3. Tạo 5 Khóa học, gán ngẫu nhiên cho 3 giảng viên
        $courses = Course::factory(5)->sequence(fn ($sequence) => [
            'user_id' => $instructors->random()->id,
        ])->create();
        
        // 4. Tạo Lessons, gắn Tag và Comment
        $courses->each(function (Course $course) use ($allTags, $students) {
            
            // Tạo số lượng Lessons ngẫu nhiên (từ 3 đến 8)
            $lessonsCount = rand(3, 8);
            
            $lessons = Lesson::factory($lessonsCount)->create(['course_id' => $course->id]);
            
            $lessons->each(function (Lesson $lesson) use ($allTags, $students) {
                // Gắn 2-3 tags ngẫu nhiên cho mỗi lesson
                $lesson->tags()->attach(
                    $allTags->random(rand(2, 3))->pluck('id')
                );

                // Tạo Comment cho Lesson (từ 1 đến 5 comments)
                Comment::factory(rand(1, 5))->create([
                    'user_id' => $students->random()->id,
                    'commentable_id' => $lesson->id,
                    'commentable_type' => Lesson::class,
                ]);
            });
            
            // Tạo Comment cho Course (từ 1 đến 3 comments)
            Comment::factory(rand(1, 3))->create([
                'user_id' => $students->random()->id,
                'commentable_id' => $course->id,
                'commentable_type' => Course::class,
            ]);
        });
        
        // --- Đảm bảo dữ liệu kiểm thử Query Builder ---
        
        // Đảm bảo có ít nhất 1 khóa học có >= 5 bài học
        $targetCourse = $courses->first(); 
        if ($targetCourse) {
            $currentLessonCount = $targetCourse->lessons()->count();
            if ($currentLessonCount < 5) {
                // Thêm Lesson nếu chưa đủ
                Lesson::factory(5 - $currentLessonCount)->create(['course_id' => $targetCourse->id]);
            }
            
            // Gắn tag 'Laravel' cho 1 lesson của khóa học này để kiểm thử
            $laravelTag = Tag::where('name', 'Laravel')->first();
            $targetCourse->lessons()->first()->tags()->syncWithoutDetaching([$laravelTag->id]);
        }
        
        $this->command->info('Dữ liệu mẫu (DemoSeeder) đã được tạo thành công!');
    }
}