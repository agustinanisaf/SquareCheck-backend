<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
		protected $table = "schedule";

    public function student () {
			return $this->hasMany('App\Models\Student');
		}

		public function subject() {
			return $this->belongsTo('App\Models\Subject');
		}
}
