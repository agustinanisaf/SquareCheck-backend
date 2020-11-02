<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleSummaryResource extends JsonResource
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
            'subject' => new SubjectResource($this->subject),
            'time' => $this->time,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'hadir' => $this->hadir,
            'izin' => $this->izin,
            'terlambat' => $this->terlambat,
            'alpa' => $this->alpa,
        ];
    }
}
