<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicCalendar extends Model
{
    use HasFactory;

    protected $table = "academic_calendar";
    
    public function types()
    {
        return $this->hasOne('App\Models\AcademicCalendarType', 'id', 'type');
    }
}
