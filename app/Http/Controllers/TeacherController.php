<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $teachers = Teacher::all();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teachers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'avatar' => 'required|url',
            'email' => 'required|email|max:50',
            'profession' => 'required|string|max:50',
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'validation error',
                'code' => 422,
                'message' => $validate->errors()
            ], 422);
        }

        $teacher = Teacher::create($data);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'avatar' => 'required|url',
            'email' => 'required|email|max:50',
            'profession' => 'required|string|max:50',
        ];

        $data = $request->all();

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'validation error',
                'code' => 422,
                'message' => $validate->errors()
            ], 422);
        }

        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
            ], 404);
        }

        $teacher->fill($data)->save();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
            ], 404);
        }

        $teacher->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ]);
    }
}
