<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $table = "classroom";

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }
}
