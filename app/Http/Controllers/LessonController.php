<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $courseId
     * @return JsonResponse
     */
    public function index($courseId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Course not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course->lessons
        ]);
    }

    /**
     * Store a newly created resource in lesson.
     *
     * @param Request $request
     * @param $courseId
     * @return JsonResponse
     */
    public function store(Request $request, $courseId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Course not found',
            ], 404);
        }

        $rules = [
            'title' => 'required|string|max:200',
            'description' => 'string|max:500',
            'source' => 'required|string',
            'type' => 'string|in:video,document',
            'chapter_id' => 'required|integer',
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'validation error',
                'code' => 422,
                'message' => $validate->errors()
            ], 422);
        }

        $lesson = $course->lessons()->create($data);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $lesson
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $courseId
     * @param $lessonId
     * @return JsonResponse
     */
    public function show($courseId, $lessonId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Course not found',
            ], 404);
        }

        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Lesson is not owned by id ' . $courseId
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $lesson
        ]);
    }

    /**
     * Update the specified resource in lesson.
     *
     * @param Request $request
     * @param $courseId
     * @param $lessonId
     * @return JsonResponse
     */
    public function update(Request $request, $courseId, $lessonId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Course not found',
            ], 404);
        }

        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Lesson is not owned by id ' . $courseId
            ], 404);
        }

        $rules = [
            'title' => 'required|string|max:200',
            'description' => 'string|max:500',
            'source' => 'required|string',
            'type' => 'string|in:video,document',
            'chapter_id' => 'required|integer',
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'validation error',
                'code' => 422,
                'message' => $validate->errors()
            ], 422);
        }

        $lesson->fill($data)->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $lesson
        ]);
    }

    /**
     * Remove the specified resource from lesson.
     *
     * @param $courseId
     * @param $lessonId
     * @return JsonResponse
     */
    public function destroy($courseId, $lessonId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Course not found',
            ], 404);
        }

        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Lesson is not owned by id ' . $courseId
            ], 404);
        }

        $lesson->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $lesson
        ]);
    }
}
