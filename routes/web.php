<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryTestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/query/lessons-count', [QueryTestController::class, 'testLessonsCount']);
Route::get('/query/lesson-by-tag', [QueryTestController::class, 'testLessonByTag']);
Route::get('/query/top-instructors', [QueryTestController::class, 'testTopInstructors']);
Route::get('/query/lesson-comment-count', [QueryTestController::class, 'testLessonCommentCount']);
