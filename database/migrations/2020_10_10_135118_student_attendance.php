<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
			Schema::create('student_attendance', function(Blueprint $table) {
				$table->integer('schedule_id')->references('id')->on('schedule');
				$table->integer('student_id')->references('id')->on('student');
				$table->date('time');
				$table->enum('status',['alpa, hadir, izin, telat']);
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
