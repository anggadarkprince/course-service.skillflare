<?php

namespace App\Http\Requests;

class CourseRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'has_certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => 'required|in:free,premium',
            'status' => 'required|in:draft,published,inactive',
            'price' => 'numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'teacher_id' => 'required|exists:teachers,id',
            'description' => 'string',
        ];
    }
}
