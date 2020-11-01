<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('lecturer_id')->constrained('lecturer');
            $table->foreignId('classroom_id')->constrained('classroom');
            $table->string("slug");
            $table->timestamps();
        });

        Schema::create('student_subject', function(Blueprint $table) {
            $table->foreignId('student_id')->constrained('student');
            $table->foreignId('subject_id')->constrained('subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_subject');
        Schema::dropIfExists('subject');
    }
}
