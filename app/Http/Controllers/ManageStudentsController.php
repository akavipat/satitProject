<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
class ManageStudentsController extends Controller
{
  public function index(){
    $students  = Student::all();

    return view('manageStudents.index' , ['students' => $students]);
  }


  public function update(Request $request)
  {
      //

      $student  = Student::all()->where('id', $request->input('id'))->first();
      $student->firstname=$request->input('firstname');



      $student->save();

      $students  = Student::all();
        return view('manageStudents.index' , ['students' => $students]);
  }
}
