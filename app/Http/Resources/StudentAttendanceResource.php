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
					'schedule_id' => $this->schedule_id,
					'student_id' => $this->student_id,
					'time' => $this->time,
					'status' => $this->status
				];
    }
}
