<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicCalendarType extends Model
{
    public function AcademicCalendar(){ 
        return $this->hasMany('App\Models\AcademicCalendar'); 
    }
}
