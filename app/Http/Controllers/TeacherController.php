<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\WrapperResource;
use App\Models\Teacher;
use Exception;

class TeacherController extends Controller
{
    /**
     * Display a listing of the teacher.
     *
     * @return TeacherCollection
     */
    public function index()
    {
        return new TeacherCollection(Teacher::paginate());
    }

    /**
     * Store a newly created teacher in storage.
     *
     * @param TeacherRequest $request
     * @return TeacherResource
     */
    public function store(TeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());

        return new TeacherResource($teacher);
    }

    /**
     * Display the specified teacher.
     *
     * @param Teacher $teacher
     * @return TeacherResource
     */
    public function show(Teacher $teacher)
    {
        return new TeacherResource($teacher, true);
    }

    /**
     * Update the specified teacher in storage.
     *
     * @param TeacherRequest $request
     * @param Teacher $teacher
     * @return TeacherResource
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $teacher->fill($request->validated())->save();

        return new TeacherResource($teacher);
    }

    /**
     * Remove the specified teacher from storage.
     *
     * @param Teacher $teacher
     * @return TeacherResource
     * @throws Exception
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return new TeacherResource($teacher);
    }
}
