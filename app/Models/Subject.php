<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $table = 'subject';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->belongsToMany('App\Models\Student')
                    ->as('student_subject');
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

    public function lecturer() {
        return $this->belongsTo('App\Models\Lecturer');
    }
}
