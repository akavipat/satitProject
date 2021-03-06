<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferedCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Offered_Courses', function (Blueprint $table) {
                      $table->unsignedInteger('classroom_id');
                      $table->unsignedSmallInteger('semester');
                      $table->unsignedSmallInteger('curriculum_year');
                      $table->string('course_id',20);
                      $table->unsignedInteger('open_course_id')->unique()->autoIncrement();
                      $table->boolean('is_elective');
                      $table->float('credits');
                      $table->string('in_class',10);
                      $table->string('practice',10);
                       $table->timestamps();

                      $table->foreign('classroom_id')
                      ->references('classroom_id')
                      ->on('Academic_Year');

                      $table->foreign(['curriculum_year','course_id'])
                      ->references(['curriculum_year','course_id'])
                      ->on('Curriculums');

                        $table->unique(['classroom_id','semester','curriculum_year','course_id'],'classtoom_id_unique');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Offered_Courses', function (Blueprint $table) {
            Schema::dropIfExists('Offered_Courses');
        });
    }
}
