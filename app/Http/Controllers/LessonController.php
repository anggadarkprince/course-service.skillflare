<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Course;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LessonController extends Controller
{
    /**
     * Display a listing of the lesson.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function index(Course $course)
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course->lessons
        ]);
    }

    /**
     * Store a newly created lesson in lesson.
     *
     * @param LessonRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function store(LessonRequest $request, Course $course)
    {
        $lesson = $course->lessons()->create($request->validated());

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $lesson
        ]);
    }

    /**
     * Display the specified lesson.
     *
     * @param Course $course
     * @param $lessonId
     * @return JsonResponse
     */
    public function show(Course $course, $lessonId)
    {
        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            throw new NotFoundHttpException('Lesson is not owned by id ' . $course->id);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $lesson
        ]);
    }

    /**
     * Update the specified lesson in lesson.
     *
     * @param LessonRequest $request
     * @param Course $course
     * @param $lessonId
     * @return JsonResponse
     */
    public function update(LessonRequest $request, Course $course, $lessonId)
    {
        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            throw new NotFoundHttpException('Lesson is not owned by id ' . $course->id);
        }

        $lesson->fill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $lesson
        ]);
    }

    /**
     * Remove the specified lesson from lesson.
     *
     * @param Course $course
     * @param $lessonId
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Course $course, $lessonId)
    {
        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            throw new NotFoundHttpException('Lesson is not owned by id ' . $course->id);
        }

        $lesson->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $lesson
        ]);
    }
}
