<?php

use Illuminate\Database\Seeder;

class OfferedCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $admin = new App\Offered_Courses;
      $admin->classroom_id = '1';
      $admin->curriculum_year = '2558';
      $admin->course_id = '01418111';
      $admin->open_course_id = '441202';
      $admin->is_elective = '1';
      $admin->credits =  '3.0';
      $admin->save();


      $admin = new App\Offered_Courses;
      $admin->classroom_id = '2';
      $admin->curriculum_year = '2559';
      $admin->course_id = '01418112';
      $admin->open_course_id = '441212';
      $admin->is_elective = '1';
      $admin->credits =  '3.0';
      $admin->save();



      $admin = new App\Offered_Courses;
      $admin->classroom_id = '3';
      $admin->curriculum_year = '2560';
      $admin->course_id = '01418113';
      $admin->open_course_id = '441210';
      $admin->is_elective = '1';
      $admin->credits =  '1.5';
      $admin->save();




      $admin = new App\Offered_Courses;
      $admin->classroom_id = '4';
      $admin->curriculum_year = '2560';
      $admin->course_id = '01418114';
      $admin->open_course_id = '411288';
      $admin->is_elective = '1';
      $admin->credits =  '3.0';
      $admin->save();




      $admin = new App\Offered_Courses;
      $admin->classroom_id = '4';
      $admin->curriculum_year = '2561';
      $admin->course_id = '01418115';
      $admin->open_course_id = '481289';
      $admin->is_elective = '1';
      $admin->credits =  '3.0';
      $admin->save();



      $admin = new App\Offered_Courses;
      $admin->classroom_id = '4';
      $admin->curriculum_year = '2560';
      $admin->course_id = '01418116';
      $admin->open_course_id = '451323';
      $admin->is_elective = '1';
      $admin->credits =  '3.0';
      $admin->save();





        //
    }
}
