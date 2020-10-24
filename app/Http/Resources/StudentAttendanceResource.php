<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'student' => [
                'id' => $this->id,
                'name' => $this->name
            ],
            'time' => $this->student_attendance->time,
            'status' => $this->student_attendance->status
        ];
    }
}
