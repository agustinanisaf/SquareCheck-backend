<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $table = "classroom";

    protected $fillable = [
        'name', 'slug', 'department_id'
    ];

    public function setSlugAttribute()
    {
        $name = $this->attributes['name'];
        $fragments = explode(" ", $name);
        $major = "";
        $slug = "";
        foreach ($fragments as $fragment) {
            if (strlen($fragment) <= 2) {
                if ($major != "")
                    $slug .= $major . " ";
                $slug .= $fragment;
            } else {
                $major .= substr($fragment, 0, 1);
                continue;
            }
            $slug .= " ";
        }

        $this->attributes['slug'] = trim($slug);
    }

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }
}
