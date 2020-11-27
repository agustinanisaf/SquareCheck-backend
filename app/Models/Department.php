<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Department extends Model
{
    use HasFactory;

    protected $table = "department";

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }

    public function lecturers()
    {
        return $this->hasMany('App\Models\Lecturer');
    }

    public function classrooms()
    {
        return $this->hasMany('App\Models\Classroom');
    }

    public function subjects()
    {
        return $this->hasManyThrough('App\Models\Subject', 'App\Models\Classroom');
    }
}
