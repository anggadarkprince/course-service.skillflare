<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseImageRequest;
use App\Http\Resources\CourseImageResource;
use App\Models\Course;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseImageController extends Controller
{
    /**
     * Display a listing of the image.
     *
     * @param Course $course
     * @return CourseImageResource
     */
    public function index(Course $course)
    {
        return new CourseImageResource($course->courseImages);
    }

    /**
     * Store a newly created image in storage.
     *
     * @param CourseImageRequest $request
     * @param Course $course
     * @return CourseImageResource
     */
    public function store(CourseImageRequest $request, Course $course)
    {
        $courseImage = $course->courseImages()->create($request->validated());

        return new CourseImageResource($courseImage);
    }

    /**
     * Display the specified image.
     *
     * @param Course $course
     * @param $courseImageId
     * @return CourseImageResource
     */
    public function show(Course $course, $courseImageId)
    {
        $courseImage = $course->courseImages()->find($courseImageId);

        if (!$courseImage) {
            throw new NotFoundHttpException('Image is not owned by id ' . $course->id);
        }

        return new CourseImageResource($courseImage);
    }

    /**
     * Remove the specified image from storage.
     *
     * @param Course $course
     * @param $courseImageId
     * @return CourseImageResource
     */
    public function destroy(Course $course, $courseImageId)
    {
        $courseImage = $course->courseImages()->find($courseImageId);

        if (!$courseImage) {
            throw new NotFoundHttpException('Image is not owned by id ' . $course->id);
        }

        $courseImage->delete();

        return new CourseImageResource($courseImage);
    }
}
