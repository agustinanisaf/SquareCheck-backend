<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $table = "classroom";

    public function setSlugAttribute()
    {
        $name = $this->attributes['name'];
        $fragments = explode(" ", $name);
        $major = "";
        $slug = "";
        foreach($fragments as $fragment){
            if(strlen($fragment) <= 2){
                if($major != "")
                    $slug .= $major . " ";
                $slug .= $fragment;
            }
            else
                $major .= substr($fragment, 1);
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
}
