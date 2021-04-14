<?php

namespace App\Http\Requests;

class TeacherRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'avatar' => 'required|url',
            'email' => 'required|email|max:50',
            'profession' => 'required|string|max:50',
        ];
    }
}
