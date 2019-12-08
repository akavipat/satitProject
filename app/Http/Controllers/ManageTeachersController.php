<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;

class ManageTeachersController extends Controller
{
  public function index(){
    $teachers  = Teacher::join('teacher_status','teachers.teacher_status','=','teacher_status.teacher_status')
    ->select('teachers.teacher_id','teachers.name_title','teachers.firstname','teachers.lastname','teacher_status.teacher_status_text')
    ->orderBy('teachers.teacher_id','asc')
    ->get();
    //dd($teachers);

    return view('manageTeachers.index' , ['teachers' => $teachers, 'query_fail' => false]);
  }

  public function update(Request $request)
  {
      //

      $teacher  = Teacher::all()->where('teacher_id', $request->input('teacherID'))->first();
      $teacher->name_title=$request->input('name_title');
      $teacher->firstname=$request->input('firstname');
      $teacher->lastname=$request->input('lastname');
      $teacher->teacher_status=$request->input('status');

      $teacher->save();

      $teachers  = Teacher::join('teacher_status','teachers.teacher_status','=','teacher_status.teacher_status')
      ->select('teachers.teacher_id','teachers.name_title','teachers.firstname','teachers.lastname','teacher_status.teacher_status_text')
      ->orderBy('teachers.teacher_id','asc')
      ->get();
      return view('manageTeachers.index' , ['teachers' => $teachers,'query_fail' => ""]);
  }

  public function add(Request $request)
    {
        $query_fail = "";

        $teacher  = new Teacher();
        $teacher->teacher_id=$request->input('teacherID');
        $teacher->name_title=$request->input('name_title');
        $teacher->firstname=$request->input('firstname');
        $teacher->lastname=$request->input('lastname');
        $teacher->teacher_status=$request->input('status');

        try {
            // create or update some data
            $teacher->saveOrFail();

        }catch(\Illuminate\Database\QueryException $e){
            $query_fail = "Cannot add new teacher information. ID ".$teacher->teacher_id." may already exists or there is a problem with the database.";
        }


        $teachers  = Teacher::join('teacher_status','teachers.teacher_status','=','teacher_status.teacher_status')
            ->select('teachers.teacher_id','teachers.name_title','teachers.firstname','teachers.lastname','teacher_status.teacher_status_text')
            ->orderBy('teachers.teacher_id','asc')
            ->get();
        return view('manageTeachers.index' , ['teachers' => $teachers,'query_fail' => $query_fail]);
    }
}
