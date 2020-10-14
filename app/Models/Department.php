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
    protected $table = "department";

    public function student()
    {
        return $this->hasMany('App\Models\Student');
    }

    public function lecturer()
    {
        return $this->hasMany('App\Models\Lecturer');
    }
}
