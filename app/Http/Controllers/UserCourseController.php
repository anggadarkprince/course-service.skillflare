<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCourseRequest;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class UserCourseController extends Controller
{
    /**
     * Display a listing of the user course.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $userCourse = UserCourse::query()->with('course');

        $userId = $request->user()->id;

        $userCourse->when($userId, function (Builder $query) use ($userId) {
            return $query->where('user_id', $userId);
        });

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $userCourse->paginate()
        ]);
    }

    /**
     * Store a newly created user course in storage.
     *
     * @param UserCourseRequest $request
     * @return JsonResponse
     */
    public function store(UserCourseRequest $request)
    {
        $user = $request->user();

        $course = Course::find($request->input('course_id'));

        if ($course->type === Course::TYPE_PREMIUM) {
            try {
                $response = Http::post(env('SERVICE_ORDER_PAYMENT_URL') . 'api/orders', [
                    'user' => $user,
                    'course' => $course->toArray()
                ]);
                return $response->json();
            } catch (Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'code' => 500,
                    'message' => 'service user unavailable'
                ], 500);
            }
        } else {
            $userCourse = UserCourse::create($request->validated());

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'data' => $userCourse
            ]);
        }
    }

    /**
     * Store a newly created user premium course in storage.
     *
     * @param UserCourseRequest $request
     * @return JsonResponse
     */
    public function storePremiumAccess(UserCourseRequest $request)
    {
        $userCourse = UserCourse::create($request->validated());

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $userCourse
        ]);
    }
}
