<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseImageController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserCourseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResources([
    'teachers' => TeacherController::class,
    'courses' => CourseController::class,
    'courses.chapters' => ChapterController::class,
    'courses.lessons' => LessonController::class,
    'courses.review' => ReviewController::class,
]);

Route::apiResource('courses.images', CourseImageController::class)->only(['index', 'store', 'destroy']);
Route::post('user-courses/premium', [UserCourseController::class, 'storePremiumAccess']);
Route::apiResource('user-courses', UserCourseController::class)->only(['index', 'store']);

Route::fallback(function () {
    return response()->json([
        'status' => 'not found',
        'code' => 404,
        'message' => 'Path not found'
    ], 404);
});
