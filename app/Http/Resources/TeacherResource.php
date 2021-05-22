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
        return [
            'status' => 'success',
            'code' => 200,
            'data' => [
                'id' => $this->id,
                'name' => $this->avatar,
                'email' => $this->email,
                'profession' => $this->profession,
                'courses' => $this->when($this->withCourses, $this->courses),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        ];
    }
}
