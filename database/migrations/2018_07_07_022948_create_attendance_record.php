<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Attendace_Records', function (Blueprint $table) {
           $table->string('student_id',50);
           $table->unsignedTinyInteger('semester');
           $table->unsignedSmallInteger('academic_year');
           $table->dateTimeTz('datetime');
            $table->timestamps();

           $table->float('late');
           $table->float('absent');
           $table->float('leave');
           $table->float('sick');
           $table->unsignedTinyInteger('data_status');

           $table->primary(['student_id','semester','academic_year','datetime'],'attendance_record_primary');
                      $table->foreign('student_id')
                      ->references('student_id')
                      ->on('Students');
           $table->foreign('data_status')
                      ->references('data_status')
                      ->on('Data_Status');
                      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Attendace_Records', function (Blueprint $table) {
            Schema::dropIfExists('Attendace_Records');
        });
    }
}
