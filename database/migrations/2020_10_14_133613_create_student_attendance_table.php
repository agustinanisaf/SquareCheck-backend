<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_attendance', function (Blueprint $table) {
            $table->foreignId('schedule_id')->constrained('schedule');
            $table->foreignId('student_id')->constrained('student');
            $table->dateTime('time')->nullable();
            $table->enum('status', ['hadir', 'izin', 'terlambat', 'alpa'])
                  ->default('alpa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_attendance');
    }
}
