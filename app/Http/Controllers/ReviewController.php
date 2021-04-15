<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Course;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function index(Course $course)
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course->reviews
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReviewRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function store(ReviewRequest $request, Course $course)
    {
        $review = $course->reviews()->create($request->validated());

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $review
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @param $reviewId
     * @return JsonResponse
     */
    public function show(Course $course, $reviewId)
    {
        $review = $course->reviews()->find($reviewId);

        if (!$review) {
            throw new NotFoundHttpException('Review is not owned by id ' . $course->id);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $review
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReviewRequest $request
     * @param Course $course
     * @param $reviewId
     * @return JsonResponse
     */
    public function update(ReviewRequest $request, Course $course, $reviewId)
    {
        $review = $course->reviews()->find($reviewId);

        if (!$review) {
            throw new NotFoundHttpException('Review is not owned by id ' . $course->id);
        }

        $review->fill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $review
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @param $reviewId
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Course $course, $reviewId)
    {
        $review = $course->reviews()->find($reviewId);

        if (!$review) {
            throw new NotFoundHttpException('Review is not owned by id ' . $course->id);
        }

        $review->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $review
        ]);
    }
}
