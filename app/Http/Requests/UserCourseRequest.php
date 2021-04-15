<?php

namespace App\Http\Requests;

use App\Rules\UniqueUserCourse;

class UserCourseRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => ['required', 'integer', 'exists:courses,id', new UniqueUserCourse($this->user()->id)],
            'user_id' => 'required|integer'
        ];
    }
}
