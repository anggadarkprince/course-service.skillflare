<?php

namespace App\Http\Requests;

class ChapterRequest extends BaseRequest
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
            'description' => 'string|max:500',
        ];
    }
}
