<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
		protected $table = 'subject';
		
		public function student() {
			return $this->hasMany('App\Models\Student');
		}

		public function schedule() {
			return $this->hasOne('App\Models\Schedule');
		}

		public function lecturer() {
			return $this->belongsTo('App\Models\Lecturer');
		}
}
