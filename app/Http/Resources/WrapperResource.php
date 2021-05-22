<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WrapperResource extends JsonResource
{
    private $code;
    private $status;

    public function __construct($resource, $code = 200, $status = 'success')
    {
        parent::__construct($resource);

        $this->code = $code;
        $this->status = $status;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'code' => $this->code,
            'data' => $this->resource,
        ];
    }
}
