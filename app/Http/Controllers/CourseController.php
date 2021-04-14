<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param CourseRequest $request
     * @return JsonResponse
     */
    public function store(CourseRequest $request)
    {
        $course = Course::create($request->validated());

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course
        ]);
    }

    /**
     * Display the specified course.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function show(Course $course)
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course->load('chapters.lessons')
        ]);
    }

    /**
     * Update the specified course in storage.
     *
     * @param CourseRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course->fill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course
        ]);
    }

    /**
     * Remove the specified course from storage.
     *
     * @param Course $course
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course
        ]);
    }
}
