<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Cần import DB Facade

class QueryTestController extends Controller
{
    /**
     * Lấy danh sách các khóa học có từ 5 bài học trở lên (dùng Query Builder).
     */
    public function testLessonsCount()
    {
        $courses = DB::table('courses')
            // Chọn tất cả các cột của courses
            ->select('courses.*')

            // Đếm số lượng bài học
            ->addSelect(DB::raw('COUNT(lessons.id) as lesson_count'))

            // Nối với bảng lessons
            ->join('lessons', 'courses.id', '=', 'lessons.course_id')

            // Nhóm theo khóa học
            // *Lưu ý: Phải GROUP BY TẤT CẢ các cột không tổng hợp*
            ->groupBy('courses.id', 'courses.title', 'courses.user_id', 'courses.created_at', 'courses.updated_at')

            // Lọc ra các nhóm có số lượng bài học >= 5
            ->having('lesson_count', '>=', 5)
            ->get();

        // Truyền dữ liệu sang View
        return view('queries.test-result', [
            'title' => 'Khóa học có >= 5 bài học',
            'results' => $courses
        ]);
    }

    /**
     * Lấy các bài học có tag 'Laravel' (dùng Query Builder).
     */
    public function testLessonByTag()
    {
        $lessons = DB::table('lessons')
            ->select('lessons.id', 'lessons.title', 'courses.title as course_title')

            // Nối lessons với bảng pivot lesson_tag
            ->join('lesson_tag', 'lessons.id', '=', 'lesson_tag.lesson_id')

            // Nối lesson_tag với bảng tags
            ->join('tags', 'lesson_tag.tag_id', '=', 'tags.id')

            // Nối với courses để hiển thị khóa học của bài học đó
            ->join('courses', 'lessons.course_id', '=', 'courses.id')

            // Lọc theo tên tag
            ->where('tags.name', 'Laravel')

            // Dùng distinct để tránh lặp bài học nếu nó có nhiều tag hoặc được join nhiều lần
            ->distinct()
            ->get();

        // Truyền dữ liệu sang View
        return view('queries.test-result', [
            'title' => 'Bài học có Tag "Laravel"',
            'results' => $lessons
        ]);
    }

    /**
     * Lấy top 3 giảng viên có nhiều khóa học nhất (dùng Query Builder).
     */
    public function testTopInstructors()
    {
        $topInstructors = DB::table('users')
            // Chọn tên user và đếm số khóa học
            ->select('users.id', 'users.name')

            // Đếm số lượng khóa học
            ->addSelect(DB::raw('COUNT(courses.id) as course_count'))

            // Nối với bảng courses
            ->join('courses', 'users.id', '=', 'courses.user_id')

            // Nhóm theo giảng viên (phải nhóm theo tất cả các cột không tổng hợp)
            ->groupBy('users.id', 'users.name')

            // Sắp xếp giảm dần theo số lượng khóa học
            ->orderByDesc('course_count')

            // Lấy top 3
            ->limit(3)
            ->get();

        // Truyền dữ liệu sang View
        return view('queries.test-result', [
            'title' => 'Top 3 Giảng viên có nhiều Khóa học nhất',
            'results' => $topInstructors
        ]);
    }

    /**
     * Đếm tổng số comment của mỗi lesson (dùng Subquery trong SELECT).
     */
    public function testLessonCommentCount()
    {
        // 1. Lấy tên class (ví dụ: App\Models\Lesson)
        $lessonClass = Lesson::class;
        
        // 2. ESCAPE dấu gạch chéo ngược ('\') thành hai dấu ('\\') 
        // để SQL hiểu đúng chuỗi.
        // PHP sẽ biến 'App\Models\Lesson' thành 'App\\Models\\Lesson' trong chuỗi SQL
        $escapedLessonClass = str_replace('\\', '\\\\', $lessonClass); 

        $lessonsWithCommentCount = DB::table('lessons')
            ->select(
                'lessons.id',
                'lessons.title',
                // Subquery đã dùng biến được escape
                DB::raw("(
                    SELECT COUNT(id) 
                    FROM comments 
                    WHERE commentable_type = '{$escapedLessonClass}' 
                    AND commentable_id = lessons.id
                ) as comments_count")
            )
            ->orderByDesc('comments_count')
            ->get();

        // Truyền dữ liệu sang View
        return view('queries.test-result', [
            'title' => 'Tổng số Comment của mỗi Lesson (dùng Subquery)',
            'results' => $lessonsWithCommentCount
        ]);
    }
}
