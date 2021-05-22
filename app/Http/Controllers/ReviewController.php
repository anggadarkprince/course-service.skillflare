<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelOwnerException;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Course;
use Exception;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Course $course
     * @return ReviewCollection
     */
    public function index(Course $course)
    {
        return new ReviewCollection($course->reviews()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReviewRequest $request
     * @param Course $course
     * @return ReviewResource
     */
    public function store(ReviewRequest $request, Course $course)
    {
        $review = $course->reviews()->create($request->validated());

        return new ReviewResource($review);
    }

    /**
     * Display the review.
     *
     * @param Course $course
     * @param $reviewId
     * @return ReviewResource
     */
    public function show(Course $course, $reviewId)
    {
        $review = $course->reviews()->find($reviewId);

        if (!$review) throw new ModelOwnerException();

        return new ReviewResource($review);
    }

    /**
     * Update the review in storage.
     *
     * @param ReviewRequest $request
     * @param Course $course
     * @param $reviewId
     * @return ReviewResource
     */
    public function update(ReviewRequest $request, Course $course, $reviewId)
    {
        $review = $course->reviews()->find($reviewId);

        if (!$review) throw new ModelOwnerException();

        $review->fill($request->validated())->save();

        return new ReviewResource($review);
    }

    /**
     * Remove the review from storage.
     *
     * @param Course $course
     * @param $reviewId
     * @return ReviewResource
     * @throws Exception
     */
    public function destroy(Course $course, $reviewId)
    {
        $review = $course->reviews()->find($reviewId);

        if (!$review) throw new ModelOwnerException();

        $review->delete();

        return new ReviewResource($review);
    }
}
