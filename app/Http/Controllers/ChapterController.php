<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelOwnerException;
use App\Http\Requests\ChapterRequest;
use App\Http\Resources\ChapterResource;
use App\Models\Course;
use Exception;

class ChapterController extends Controller
{
    /**
     * Display a listing of the chapter.
     *
     * @param Course $course
     * @return ChapterResource
     */
    public function index(Course $course)
    {
        return new ChapterResource($course->chapters);
    }

    /**
     * Store a newly created chapter in storage.
     *
     * @param ChapterRequest $request
     * @param Course $course
     * @return ChapterResource
     */
    public function store(ChapterRequest $request, Course $course)
    {
        $chapter = $course->chapters()->create($request->validated());

        return new ChapterResource($chapter);
    }

    /**
     * Display the specified chapter.
     *
     * @param Course $course
     * @param $chapterId
     * @return ChapterResource
     */
    public function show(Course $course, $chapterId)
    {
        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) throw new ModelOwnerException();

        return new ChapterResource($chapter);
    }

    /**
     * Update the specified chapter in storage.
     *
     * @param ChapterRequest $request
     * @param Course $course
     * @param $chapterId
     * @return ChapterResource
     */
    public function update(ChapterRequest $request, Course $course, $chapterId)
    {
        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) throw new ModelOwnerException();

        $chapter->fill($request->validated())->save();

        return new ChapterResource($chapter);
    }

    /**
     * Remove the specified chapter from storage.
     *
     * @param Course $course
     * @param $chapterId
     * @return ChapterResource
     * @throws Exception
     */
    public function destroy(Course $course, $chapterId)
    {
        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) throw new ModelOwnerException();

        $chapter->delete();

        return new ChapterResource($chapter);
    }
}
