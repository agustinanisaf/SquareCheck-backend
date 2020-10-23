<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    /**
     * The primary key of the corresponding model.
     *
     * @var array
     */
    protected $primaryKey = ['schedule_id', 'student_id'];

    /**
     * The incrementing mode for primary key of the corresponding model.
     *
     * @var array
     */
    public $incrementing = false;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $table = "student_attendance";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time', 'status',
    ];
}
