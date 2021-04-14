<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\JsonResponse;

class TeacherController extends Controller
{
    /**
     * Display a listing of the teacher.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => Teacher::paginate()
        ]);
    }

    /**
     * Store a newly created teacher in storage.
     *
     * @param TeacherRequest $request
     * @return JsonResponse
     */
    public function store(TeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ]);
    }

    /**
     * Display the specified teacher.
     *
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function show(Teacher $teacher)
    {
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ]);
    }

    /**
     * Update the specified teacher in storage.
     *
     * @param TeacherRequest $request
     * @param Teacher $teacher
     * @return JsonResponse
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $teacher->fill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ]);
    }

    /**
     * Remove the specified teacher from storage.
     *
     * @param Teacher $teacher
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ]);
    }
}
