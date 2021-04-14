<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Models\Course;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChapterController extends Controller
{
    /**
     * Display a listing of the chapter.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function index(Course $course)
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $course->chapters
        ]);
    }

    /**
     * Store a newly created chapter in storage.
     *
     * @param ChapterRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function store(ChapterRequest $request, Course $course)
    {
        $chapter = $course->chapters()->create($request->validated());

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $chapter
        ]);
    }

    /**
     * Display the specified chapter.
     *
     * @param Course $course
     * @param $chapterId
     * @return JsonResponse
     */
    public function show(Course $course, $chapterId)
    {
        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) {
            throw new NotFoundHttpException('Chapter is not owned by id ' . $course->id);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $chapter->load('lessons')
        ]);
    }

    /**
     * Update the specified chapter in storage.
     *
     * @param ChapterRequest $request
     * @param Course $course
     * @param $chapterId
     * @return JsonResponse
     */
    public function update(ChapterRequest $request, Course $course, $chapterId)
    {
        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) {
            throw new NotFoundHttpException('Chapter is not owned by id ' . $course->id);
        }

        $chapter->fill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $chapter
        ]);
    }

    /**
     * Remove the specified chapter from storage.
     *
     * @param Course $course
     * @param $chapterId
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Course $course, $chapterId)
    {
        $chapter = $course->chapters()->find($chapterId);

        if (!$chapter) {
            throw new NotFoundHttpException('Chapter is not owned by id ' . $course->id);
        }

        $chapter->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $chapter
        ]);
    }
}
