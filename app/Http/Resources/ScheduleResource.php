<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'id' => $this->id,
            'subject' => [
                'id' => $this->subject->id,
                'name' => $this->subject->name
            ],
            'time' => $this->time,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time
        ];
    }
}
