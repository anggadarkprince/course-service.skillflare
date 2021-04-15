<?php

namespace App\Rules;

use App\Models\UserCourse;
use Illuminate\Contracts\Validation\Rule;

class UniqueUserCourse implements Rule
{
    private $userId;
    private $exceptId;

    /**
     * Create a new rule instance.
     *
     * @param $userId
     * @param $exceptId
     */
    public function __construct($userId, $exceptId)
    {
        $this->userId = $userId;
        $this->exceptId = $exceptId ?: 0;
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
        return !UserCourse::where([
            'user_id' => $this->userId,
            'course_id' => $value
        ])
            ->where('id', '!=', $this->exceptId)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is already owned by user.';
    }
}
