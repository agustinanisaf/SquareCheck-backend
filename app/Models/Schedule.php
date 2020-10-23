<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $table = "schedule";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time'
    ];

    public function students()
    {
        return $this->belongsToMany(
                        'App\Models\Student',
                        'student_attendance',
                        'schedule_id',
                        'student_id'
                    )
                    ->as('student_attendance')
                    ->withPivot([
                        'time',
                        'status',
                    ]);
    }

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
}
