<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the course.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $courses = Course::query();

        $q = $request->query('q');
        $status = $request->query('status');

        $courses->when($q, function ($query) use ($q) {
            return $query->whereRaw("title LIKE '%" . strtolower($q) . "%'");
        });

        $courses->when($status, function ($query) use ($status) {
            return $query->where("status", $status);
        });

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $courses->paginate()
        ]);
    }

    /**
     * Store a newly created course in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:100',
            'has_certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => 'required|in:free,premium',
            'status' => 'required|in:draft,published,inactive',
            'price' => 'numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'teacher_id' => 'required|exists:teachers,id',
            'description' => 'string',
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

        $course = Course::create($data);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course
        ]);
    }

    /**
     * Display the specified course.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course
        ]);
    }

    /**
     * Update the specified course in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|string|max:100',
            'has_certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => 'required|in:free,premium',
            'status' => 'required|in:draft,published,inactive',
            'price' => 'numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'teacher_id' => 'required|exists:teachers,id',
            'description' => 'string',
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

        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
            ], 404);
        }

        $course->fill($data)->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course
        ]);
    }

    /**
     * Remove the specified course from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
            ], 404);
        }

        $course->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course
        ]);
    }
}
