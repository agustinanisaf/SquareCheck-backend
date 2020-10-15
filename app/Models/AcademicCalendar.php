<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicCalendar extends Model
{
    protected $table = "academic_calendars";

    public function AcademicCalendarType(){ 
        return $this->belongsTo('App\Models\AcademicCalendarType');
    }
}
