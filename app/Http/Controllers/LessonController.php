<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LessonController extends Controller
{
    /**
     * Display a listing of the lesson.
     *
     * @param Course $course
     * @return LessonResource
     */
    public function index(Course $course)
    {
        return new LessonResource($course->lessons);
    }

    /**
     * Store a newly created lesson in lesson.
     *
     * @param LessonRequest $request
     * @param Course $course
     * @return LessonResource
     */
    public function store(LessonRequest $request, Course $course)
    {
        $lesson = $course->lessons()->create($request->validated());

        return new LessonResource($lesson);
    }

    /**
     * Display the specified lesson.
     *
     * @param Course $course
     * @param $lessonId
     * @return LessonResource
     */
    public function show(Course $course, $lessonId)
    {
        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            throw new NotFoundHttpException('Lesson is not owned by id ' . $course->id);
        }

        return new LessonResource($lesson);
    }

    /**
     * Update the specified lesson in lesson.
     *
     * @param LessonRequest $request
     * @param Course $course
     * @param $lessonId
     * @return LessonResource
     */
    public function update(LessonRequest $request, Course $course, $lessonId)
    {
        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            throw new NotFoundHttpException('Lesson is not owned by id ' . $course->id);
        }

        $lesson->fill($request->validated())->save();

        return new LessonResource($lesson);
    }

    /**
     * Remove the specified lesson from lesson.
     *
     * @param Course $course
     * @param $lessonId
     * @return LessonResource
     */
    public function destroy(Course $course, $lessonId)
    {
        $lesson = $course->lessons()->find($lessonId);

        if (!$lesson) {
            throw new NotFoundHttpException('Lesson is not owned by id ' . $course->id);
        }

        $lesson->delete();

        return new LessonResource($lesson);
    }
}
