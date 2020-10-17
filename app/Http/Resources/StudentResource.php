<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
					'first_name' => $this->first_name,
					'last_name' => $this->last_name,
					'nrp' => $this->nrp,
					'department_id' => $this->department_id,
					'user_id' => $this->user_id
				];
    }
}