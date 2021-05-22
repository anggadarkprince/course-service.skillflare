<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    private $withCourses;

    public function __construct($resource, $withCourses = false)
    {
        parent::__construct($resource);

        $this->withCourses = $withCourses;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $teacher = [
            'id' => $this->id,
            'name' => $this->avatar,
            'email' => $this->email,
            'profession' => $this->profession,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->withCourses) {
            $teacher['courses'] = $this->courses;
        }

        return [
            'status' => 'success',
            'code' => 200,
            'data' => $teacher
        ];
    }
}
