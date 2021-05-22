<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the course.
     *
     * @param Request $request
     * @return CourseCollection
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

        return new CourseCollection($courses->paginate());
    }

    /**
     * Store a newly created course in storage.
     *
     * @param CourseRequest $request
     * @return CourseResource
     */
    public function store(CourseRequest $request)
    {
        $course = Course::create($request->validated());

        return new CourseResource($course);
    }

    /**
     * Display the specified course.
     *
     * @param Course $course
     * @return CourseResource
     */
    public function show(Course $course)
    {
        $course['total_user'] = UserCourse::where('course_id', $course->id)->count();

        return new CourseResource($course
            ->load('chapters.lessons')
            ->load('teacher')
            ->load('courseImages')
            ->load(['reviews' => function (Relation $builder) {
                $builder->take(100);
            }])
        );
    }

    /**
     * Update the specified course in storage.
     *
     * @param CourseRequest $request
     * @param Course $course
     * @return CourseResource
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course->fill($request->validated())->save();

        return new CourseResource($course);
    }

    /**
     * Remove the specified course from storage.
     *
     * @param Course $course
     * @return CourseResource
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return new CourseResource($course);
    }
}
