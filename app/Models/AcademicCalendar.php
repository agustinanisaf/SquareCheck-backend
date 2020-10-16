<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class AcademicCalendar extends Model
{
    use HasFactory;

    protected $table = "academic_calendar";
    
    public function AcademicCalendarType(){ 
        return $this->belongsTo('App\Models\AcademicCalendarType');
    }
}
