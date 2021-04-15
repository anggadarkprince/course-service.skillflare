<?php

namespace App\Rules;

use App\Models\Review;
use Illuminate\Contracts\Validation\Rule;

class UniqueUserReview implements Rule
{
    private $userId;

    /**
     * Create a new rule instance.
     *
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !Review::where(['user_id' => $this->userId, 'course_id' => $value])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is already reviewed by user.';
    }
}
