<?php

namespace App\Http\Requests;

class LessonRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:200',
            'description' => 'string|max:500',
            'source' => 'required|string',
            'type' => 'string|in:video,document',
            'chapter_id' => 'required|integer',
        ];
    }
}
