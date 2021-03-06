<?php

namespace App\Http\Requests;

use App\Rules\UniqueUserReview;

class ReviewRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $reviewId = $this->route('review');

        return [
            'user_id' => 'required|integer',
            'course_id' => ['required', 'exists:courses,id', new UniqueUserReview($this->input('user_id'), $reviewId)],
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'string|max:2000'
        ];
    }
}
