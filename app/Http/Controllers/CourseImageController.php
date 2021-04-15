<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseImageRequest;
use App\Models\Course;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseImageController extends Controller
{
    /**
     * Display a listing of the image.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function index(Course $course)
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course->courseImages
        ]);
    }

    /**
     * Store a newly created image in storage.
     *
     * @param CourseImageRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function store(CourseImageRequest $request, Course $course)
    {
        $courseImage = $course->courseImages()->create($request->validated());

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $courseImage
        ]);
    }

    /**
     * Display the specified image.
     *
     * @param Course $course
     * @param $courseImageId
     * @return JsonResponse
     */
    public function show(Course $course, $courseImageId)
    {
        $courseImage = $course->courseImages()->find($courseImageId);

        if (!$courseImage) {
            throw new NotFoundHttpException('Image is not owned by id ' . $course->id);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $courseImage
        ]);
    }

    /**
     * Remove the specified image from storage.
     *
     * @param Course $course
     * @param $courseImageId
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Course $course, $courseImageId)
    {
        $courseImage = $course->courseImages()->find($courseImageId);

        if (!$courseImage) {
            throw new NotFoundHttpException('Image is not owned by id ' . $course->id);
        }

        $courseImage->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $courseImage
        ]);
    }
}
