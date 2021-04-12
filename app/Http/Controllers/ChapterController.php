<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    /**
     * Display a listing of the chapter.
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
            'data' => $course->chapters
        ]);
    }

    /**
     * Store a newly created chapter in storage.
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
            'title' => 'required|string|max:100',
            'description' => 'string|max:500',
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

        $chapter = $course->chapters()->create($data);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $chapter->load('course')
        ]);
    }

    /**
     * Display the specified chapter.
     *
     * @param $courseId
     * @param $chapterId
     * @return JsonResponse
     */
    public function show($courseId, $chapterId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Course not found',
            ], 404);
        }

        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Chapter is not owned by id ' . $courseId
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $chapter
        ]);
    }

    /**
     * Update the specified chapter in storage.
     *
     * @param Request $request
     * @param $courseId
     * @param $chapterId
     * @return JsonResponse
     */
    public function update(Request $request, $courseId, $chapterId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Course not found',
            ], 404);
        }

        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Chapter is not owned by id ' . $courseId
            ], 404);
        }

        $rules = [
            'title' => 'required|string|max:100',
            'description' => 'string|max:500',
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

        $chapter->fill($data)->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $chapter
        ]);
    }

    /**
     * Remove the specified chapter from storage.
     *
     * @param $courseId
     * @param $chapterId
     * @return JsonResponse
     */
    public function destroy($courseId, $chapterId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Course not found',
            ], 404);
        }

        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'Chapter is not owned by id ' . $courseId
            ], 404);
        }

        $chapter->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $chapter
        ]);
    }
}
