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

    public function setSlugAttribute()
    {
        $name = $this->attributes['name'];
        $fragments = explode(" ", $name);
        $slug = "";
        foreach ($fragments as $fragment) {
            $slug .= $fragment[0];
        }

        $this->attributes['slug'] = trim($slug);
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

    public function lecturer()
    {
        return $this->belongsTo('App\Models\Lecturer');
    }

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }
}
