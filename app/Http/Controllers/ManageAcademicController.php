<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Academic_Year;
use App\Curriculum;
use App\Offered_Courses;
use App\Student_Grade_Level;
use App\Homeroom;
use App\Teacher;
use App\Student;
use App\Information;

class ManageAcademicController extends Controller
{
  private function getCurrentActiveYear(){ // Function get active year from Information table
    $info  = Information::first();
    $year = $info->active_year;
    return $year;
  }

  private function checkAvailableYear($year){
    $activeYear = $this->getCurrentActiveYear();
    $checkYear = Academic_Year::where('academic_year', $year)->first();
    if($year < $activeYear || $checkYear == null){

      return false;
    }
    return true;
  }

  private function checkAvailableYearRoomLevel($year,$grade,$room){
    $activeYear = $this->getCurrentActiveYear();
    $checkYear = Academic_Year::where('academic_year', $year)
                              ->where('room', $room)
                              ->where('grade_level',$grade)
                              ->first();
    if($year < $activeYear || $checkYear == null){
      return false;
    }
    return true;
  }

  public function index(){
    //$academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();
    $year = $this->getCurrentActiveYear();
    return view('manageAcademic.index' , ['cur_year' => $year]);
  }

  public function editCurAcademicYear(){
    $year = $this->getCurrentActiveYear();
    $activeYear = $this->getCurrentActiveYear();
    $academicDetail = Academic_Year::where('academic_year', $year)->orderBy('grade_level', 'asc')->get();
    $academicAbove  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->where('academic_year',">=",$year)->get();
    $curriculum  = Curriculum::orderBy('curriculum_year', 'asc')->groupBy('curriculum_year')->get();
    return view('manageAcademic.academicTable' , ['active_year' => $activeYear,'cur_year' => $year,'sel_year' => $academicAbove,'academicDetail'=>$academicDetail]);
  }

  public function editAcademicYear($year){
    $activeYear = $this->getCurrentActiveYear();
    $checkYear = Academic_Year::where('academic_year', $year)->first();
    if($year < $activeYear || $checkYear == null){
      $redi  = "editCurrentAcademic";
      return redirect($redi);
    }
    $academicDetail = Academic_Year::where('academic_year', $year)->orderBy('grade_level', 'asc')->get();
    $academicAbove  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->where('academic_year',">=",$activeYear)->get();
    $curriculum  = Curriculum::orderBy('curriculum_year', 'asc')->groupBy('curriculum_year')->get();
    return view('manageAcademic.academicTable' , ['active_year' => $activeYear,'cur_year' => $year,'sel_year' => $academicAbove,'academicDetail'=>$academicDetail]);
  }

  public function changeEditAcademicYear(Request $request){
    $year = $this->getCurrentActiveYear();
    $selYear = $request->input('selYear');
    $academicDetail = Academic_Year::where('academic_year', $selYear)->orderBy('grade_level', 'asc')->get();
    $academicAbove  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->where('academic_year',">=",$year)->get();
    $curriculum  = Curriculum::orderBy('curriculum_year', 'asc')->groupBy('curriculum_year')->get();
    return view('manageAcademic.academicTable' , ['cur_year' => $selYear,'sel_year' => $academicAbove,'academicDetail'=>$academicDetail]);
  }

  public function activeAcademicYear(Request $request){
    try{
      $info  = Information::first();
      $info->active_year = $request->input('year');
      $info->save();
    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }
    return  response()->json(['Status' =>"success"], 200);
  }

  public function addNewAcademic(){

    $getYear  = Academic_Year::orderBy('academic_year', 'desc')->first();
    $academic  = Academic_Year::where('academic_year', $getYear->academic_year)->get();

      try{
        foreach ($academic as $aca) {
          $createNewYear = $aca->replicate();
          $createNewYear->academic_year = ($aca->academic_year)+1;
          $createNewYear->classroom_id = null;
          $createNewYear->save();
        }
      }
      catch(\Exception $e){
         // do task when error
         return response()->json(['Status' => $e->getMessage()], 200);

      }


    return  response()->json(['Status' =>"success"], 200);
  }



  public function assignSubject($year,$grade,$room,Request $request){
    if(!$this->checkAvailableYearRoomLevel($year,$grade,$room)){
      $redi  = "editAcademic/".$this->getCurrentActiveYear();
      return redirect($redi);
    }

    $curricula_year  = Curriculum::orderBy('curriculum_year', 'asc')->groupBy('curriculum_year')->get();
    $academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();

    if($room === 0){
      $academic  = Academic_Year::where('academic_year', $year)
                                ->where('grade_level', $grade)
                                ->get();
    }
    else if($room >= 1 and $room <= 12){
      $academic  = Academic_Year::where('academic_year', $year)
                                ->where('room', $room)
                                ->where('grade_level', $grade)
                                ->get();
    }
    $selCur = 0;
    if(!isset($academic[0])){ // No classroom id
      $courses = [];
      $allSub =[];
    }
    else{
      $courses  = Academic_Year::where('academic_year.academic_year', $year)
              ->where('academic_year.classroom_id', $academic[0]->classroom_id)
              ->Join('offered_courses','offered_courses.classroom_id','=','academic_year.classroom_id')
              ->Join('curriculums', function($join)
                  {
                      $join->on('curriculums.course_id', '=', 'offered_courses.course_id');
                      $join->on('curriculums.curriculum_year','=', 'offered_courses.curriculum_year');
                  })
              ->select('offered_courses.open_course_id','academic_year.academic_year','curriculums.course_id','academic_year.grade_level','academic_year.room'
                      ,'curriculums.course_name','offered_courses.credits','offered_courses.semester','offered_courses.is_elective')
              ->get();
      $selCur = $academic[0]->curriculum_year;
      $allSub = Curriculum::where('min_grade_level','<=',$grade)
                          ->where('max_grade_level','>=',$grade)
                          ->where('curriculum_year',$academic[0]->curriculum_year)
                          ->get();
    }
    return view('manageAcademic.assignSubject' , ['cur_year' => $year,'grade'=>$grade,'room'=>$room,'subs'=>$courses,'curricula'=>$curricula_year,
                'selCur'=>$selCur,'allSub'=>$allSub]);
  }

  public function assignStudent($year,$grade,$room,Request $request){
    $academicCheck = Academic_Year::where('academic_year', $year)
                              ->where('room', $room)
                              ->where('grade_level', $grade)
                              ->first();
    if(!$this->checkAvailableYearRoomLevel($year,$grade,$room)){
      $redi  = "editAcademic/".$this->getCurrentActiveYear();
      return redirect($redi);
    }

    $curricula_year  = Curriculum::orderBy('curriculum_year', 'asc')->groupBy('curriculum_year')->get();
    $academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();

    if($room === 0){
      $academic  = Academic_Year::where('academic_year', $year)
                                ->where('grade_level', $grade)
                                ->get();
    }
    else {
      $academic  = Academic_Year::where('academic_year', $year)
                                ->where('room', $room)
                                ->where('grade_level', $grade)
                                ->get();
    }
    $selCur = 0;
    if(!isset($academic[0])){ // No classroom id
      $courses = [];
      $std_in = [];
    }
    else{
      $std_in  = Student_Grade_Level::where('classroom_id', $academic[0]->classroom_id)
              ->Join('students','student_grade_levels.student_id','students.student_id')
              ->select('students.firstname','students.lastname','students.student_id')
              ->get();
    }
    $std_cannot_add  = Student_Grade_Level::Join('academic_year','student_grade_levels.classroom_id','academic_year.classroom_id')
                              ->where('academic_year.academic_year', $year)
                              ->get();

    $temp = Academic_Year::where('academic_year', $year)
                          ->pluck('classroom_id');
    $in = array();
    foreach ($std_cannot_add as $std) {
      $in[] = $std->student_id;
    }
    /*
    $allStd = Student::where('student_status',0)
                      ->leftJoin('student_grade_levels','student_grade_levels.student_id','students.student_id')
                      ->leftJoin('academic_year','student_grade_levels.classroom_id','academic_year.classroom_id')
                      ->where('student_grade_levels.classroom_id','!=',$academic[0]->classroom_id)
                      ->select('students.student_id','students.firstname','students.lastname')
                      ->get();
    */
    $allStd = Student::where('student_status',0)
                      ->whereNotIn('student_id',$in)
                      ->get();
    return view('manageAcademic.assignStudent' , ['cur_year' => $year,'grade'=>$grade,'room'=>$room,'stds'=>$std_in,'curricula'=>$curricula_year
                ,'allStd'=>$allStd,'class_id'=>$academic[0]->classroom_id]);
  }

  public function addRoom(Request $request){
    $grade = $request->input('grade');
    $year = $request->input('year');
    $academic  = Academic_Year::where('academic_year',$year)->where('grade_level',$grade)->orderBy('room', 'desc')->first();
    $room = $academic->room;


    try{
    $createNewRoom = new Academic_Year;
    $createNewRoom->academic_year = $year;
    $createNewRoom->grade_level = $grade;
    $createNewRoom->room = $room+1;
    $createNewRoom->curriculum_year = $academic->curriculum_year;
    $createNewRoom->save();
    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }

    return response()->json(['Status' => 'success'], 200);
  }

  public function removeRoom(Request $request){
    $grade = $request->input('grade');
    $year = $request->input('year');



    try{
      $academic  = Academic_Year::where('academic_year',$year)->where('grade_level',$grade)->orderBy('room', 'desc')->first();
      $room = $academic->room;
      Academic_Year::where('academic_year',$year)->where('grade_level',$grade)->where('room', $room)->delete();
    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }

    return response()->json(['Status' => 'success'], 200);
  }


  public function importStdFromPrevious(Request $request){
    try{
    $activeYear = $this->getCurrentActiveYear();

    $year = $request->input('year');
    if($year < $activeYear){
      return response()->json(['Status' => "Academic Year ".$year." could not edit"], 200);
    }
    $stds =  Student_Grade_Level::where('academic_year',$year-1)
                              ->leftJoin('academic_year','academic_year.classroom_id','student_grade_levels.classroom_id')
                              ->get();
                              /*
    if($checkAca === null){ // No classroom
      return response()->json(['Status' => 'No previous year student, Can not import', 200]);
    }*/


      $checkStdExistYear =  Student_Grade_Level::leftJoin('academic_year','student_grade_levels.classroom_id','academic_year.classroom_id')
                                                ->where('academic_year.academic_year',$year)
                                                ->delete();
    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }

    try{
    $class_temp = -1;
    foreach ($stds as $std) {
      if($class_temp != $std->classroom_id){
        $class_temp = $std->classroom_id;

        $checkAca =  Academic_Year::where('academic_year',$year)
                                  ->where('grade_level',$std->grade_level)
                                  ->where('room',$std->room)
                                  ->first();

        if($checkAca == null){ // No classroom
          $createAca = new Academic_Year;
          $createAca->academic_year = $year;
          $createAca->grade_level = $std->grade_level;
          $createAca->room = $std->room;
          $createAca->curriculum_year = $std->curriculum_year;
          $createAca->save();
        }


      }
      $this_class_id =  Academic_Year::where('academic_year',$year)
                                  ->where('grade_level',$std->grade_level)
                                  ->where('room',$std->room)
                                  ->first();


        $addStd = new Student_Grade_Level;
        $addStd->student_id = $std->student_id;
        $addStd->classroom_id = $this_class_id->classroom_id;
        $addStd->save();
      }


    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }




    return response()->json(['Status' => 'success'], 200);
  }


  public function addStudent(Request $request){
    $room = $request->input('room');
    $grade = $request->input('grade');
    $std_id = $request->input('std_id');
    $curYear = Curriculum::orderBy('curriculum_year', 'desc')->groupBy('curriculum_year')->get();
    //$academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();
    //$year = $academic->academic_year;
    $year = $request->input('year');
    if(!$this->checkAvailableYearRoomLevel($year,$grade,$room)){
      return response()->json(['Status' => "Could not add to this academic year or grade_level/room does not exist"], 200);
    }



    $checkAca =  Academic_Year::where('academic_year',$year)
                              ->where('grade_level',$grade)
                              ->where('room',$room)
                              ->get();

    if(!isset($checkAca[0])){ // No classroom
      $createAca = new Academic_Year;
      $createAca->academic_year = $year;
      $createAca->grade_level = $grade;
      $createAca->room = $room;
      $createAca->curriculum_year = $curYear[0]->curriculum_year;
      $createAca->save();


    }
    $checkAca =  Academic_Year::where('academic_year',$year)
                              ->where('grade_level',$grade)
                              ->where('room',$room)
                              ->get();

    $checkStdExistYear =  Student_Grade_Level::where('student_id',$std_id)
                                              ->leftJoin('academic_year','student_grade_levels.classroom_id','academic_year.classroom_id')
                                              ->where('academic_year.academic_year',$year)
                                              ->first();
    if($checkStdExistYear != null){
      return response()->json(['Status' => 'student already in grade '.$checkStdExistYear->grade_level.' room '.$checkStdExistYear->room], 200);
    }
    try{
    $createStuClass = new Student_Grade_Level;
    $createStuClass->classroom_id = $checkAca[0]->classroom_id;
    $createStuClass->student_id = $std_id;
    $createStuClass->save();
    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }

    return response()->json(['Status' => 'success'], 200);
  }

  public function removeStudent(Request $request){
    $room = $request->input('room');
    $grade = $request->input('grade');
    $std_id = $request->input('std_id');
    $curYear = Curriculum::orderBy('curriculum_year', 'desc')->groupBy('curriculum_year')->get();
    $academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();
    $year = $request->input('year');

    if(!$this->checkAvailableYearRoomLevel($year,$grade,$room)){
      return response()->json(['Status' => "Could not add to this academic year or grade_level/room does not exist"], 200);
    }




    try{
      $checkStdExistYear =  Student_Grade_Level::where('student_id',$std_id)
                                                ->leftJoin('academic_year','student_grade_levels.classroom_id','academic_year.classroom_id')
                                                ->where('academic_year.academic_year',$year)
                                                ->where('academic_year.room',$room)
                                                ->where('academic_year.grade_level',$grade)
                                                ->delete();
    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }

    return response()->json(['Status' => 'success'], 200);
  }

  // Teacher


    public function assignTeacher($year,$grade,$room,Request $request){
      $academicCheck = Academic_Year::where('academic_year', $year)
                                ->where('room', $room)
                                ->where('grade_level', $grade)
                                ->first();
      if(!$this->checkAvailableYearRoomLevel($year,$grade,$room)){
        $redi  = "editAcademic/".$this->getCurrentActiveYear();
        return redirect($redi);
      }

      $curricula_year  = Curriculum::orderBy('curriculum_year', 'asc')->groupBy('curriculum_year')->get();
      $academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();

      if($room === 0){
        $academic  = Academic_Year::where('academic_year', $year)
                                  ->where('grade_level', $grade)
                                  ->get();
      }
      else {
        $academic  = Academic_Year::where('academic_year', $year)
                                  ->where('room', $room)
                                  ->where('grade_level', $grade)
                                  ->get();
      }
      $selCur = 0;
      if(!isset($academic[0])){ // No classroom id
        $courses = [];
        $teacher_in = [];
      }
      else{
        $teacher_in  = Homeroom::where('classroom_id', $academic[0]->classroom_id)
                ->Join('teachers','homeroom.teacher_id','teachers.teacher_id')
                ->select('teachers.name_title','teachers.firstname','teachers.lastname','teachers.teacher_id')
                ->get();
      }
      $teacher_cannot_add  = Homeroom::Join('academic_year','homeroom.classroom_id','academic_year.classroom_id')
                                ->where('academic_year.academic_year', $year)
                                ->get();

      $temp = Academic_Year::where('academic_year', $year)
                            ->pluck('classroom_id');
      $in = array();
      foreach ($teacher_cannot_add as $teacher) {
        $in[] = $teacher->teacher_id;
      }
      /*
      $allteacher = Teacher::where('teacher_status',0)
                        ->leftJoin('teacher_grade_levels','teacher_grade_levels.teacher_id','teachers.teacher_id')
                        ->leftJoin('academic_year','teacher_grade_levels.classroom_id','academic_year.classroom_id')
                        ->where('teacher_grade_levels.classroom_id','!=',$academic[0]->classroom_id)
                        ->select('teachers.teacher_id','teachers.firstname','teachers.lastname')
                        ->get();
      */
      $allTeacher = Teacher::where('teacher_status',0)
                        ->whereNotIn('teacher_id',$in)
                        ->get();
      return view('manageAcademic.assignTeacher' , ['cur_year' => $year,'grade'=>$grade,'room'=>$room,'teachers'=>$teacher_in,'curricula'=>$curricula_year
                  ,'allTeacher'=>$allTeacher,'class_id'=>$academic[0]->classroom_id]);
    }

    public function addTeacher(Request $request){
      try{


      $room = $request->input('room');
      $grade = $request->input('grade');
      $teacher_id = $request->input('teacher_id');
      $curYear = Curriculum::orderBy('curriculum_year', 'desc')->groupBy('curriculum_year')->get();
      //$academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();
      //$year = $academic->academic_year;
      $year = $request->input('year');
      if(!$this->checkAvailableYearRoomLevel($year,$grade,$room)){
        return response()->json(['Status' => "Could not add to this academic year or grade/room does not exist"], 200);
      }



      $checkAca =  Academic_Year::where('academic_year',$year)
                                ->where('grade_level',$grade)
                                ->where('room',$room)
                                ->get();

      if(!isset($checkAca[0])){ // No classroom
        $createAca = new Academic_Year;
        $createAca->academic_year = $year;
        $createAca->grade_level = $grade;
        $createAca->room = $room;
        $createAca->curriculum_year = $curYear[0]->curriculum_year;
        $createAca->save();


      }
      $checkAca =  Academic_Year::where('academic_year',$year)
                                ->where('grade_level',$grade)
                                ->where('room',$room)
                                ->get();

      $checkTeacherExistYear =  Homeroom::where('teacher_id',$teacher_id)
                                                ->leftJoin('academic_year','homeroom.classroom_id','academic_year.classroom_id')
                                                ->where('academic_year.academic_year',$year)
                                                ->first();
      if($checkTeacherExistYear != null){
        return response()->json(['Status' => 'teacher already in grade '.$checkTeacherExistYear->grade_level.' room '.$checkTeacherExistYear->room], 200);
      }
    }// end try
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }
      try{
      $createTeacherClass = new Homeroom;
      $createTeacherClass->classroom_id = $checkAca[0]->classroom_id;
      $createTeacherClass->teacher_id = $teacher_id;
      $createTeacherClass->save();
      }
      catch(\Exception $e){
         // do task when error
         return response()->json(['Status' => $e->getMessage()], 200);

      }

      return response()->json(['Status' => 'success'], 200);
    }

    public function removeTeacher(Request $request){
      $room = $request->input('room');
      $grade = $request->input('grade');
      $teacher_id = $request->input('teacher_id');
      $curYear = Curriculum::orderBy('curriculum_year', 'desc')->groupBy('curriculum_year')->get();
      $academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();
      $year = $request->input('year');

      if(!$this->checkAvailableYearRoomLevel($year,$grade,$room)){
        return response()->json(['Status' => "Could not add to this academic year or grade_level/room does not exist"], 200);
      }




      try{
        $checkteacherExistYear =  Homeroom::where('teacher_id',$teacher_id)
                                                  ->leftJoin('academic_year','homeroom.classroom_id','academic_year.classroom_id')
                                                  ->where('academic_year.academic_year',$year)
                                                  ->where('academic_year.room',$room)
                                                  ->where('academic_year.grade_level',$grade)
                                                  ->delete();
      }
      catch(\Exception $e){
         // do task when error
         return response()->json(['Status' => $e->getMessage()], 200);

      }

      return response()->json(['Status' => 'success'], 200);
    }

    public function importTeacherFromPrevious(Request $request){
      try{
      $activeYear = $this->getCurrentActiveYear();

      $year = $request->input('year');
      if($year < $activeYear){
        return response()->json(['Status' => "Academic Year ".$year." could not edit"], 200);
      }
      $teachers =  Homeroom::where('academic_year',$year-1)
                                ->leftJoin('academic_year','academic_year.classroom_id','homeroom.classroom_id')
                                ->get();
                                /*
      if($checkAca === null){ // No classroom
        return response()->json(['Status' => 'No previous year teacher, Can not import', 200]);
      }*/


        $checkTeacherExistYear =  Homeroom::leftJoin('academic_year','homeroom.classroom_id','academic_year.classroom_id')
                                                  ->where('academic_year.academic_year',$year)
                                                  ->delete();
      }
      catch(\Exception $e){
         // do task when error
         return response()->json(['Status' => $e->getMessage()], 200);

      }

      try{
      $class_temp = -1;
      foreach ($teachers as $teacher) {
        if($class_temp != $teacher->classroom_id){
          $class_temp = $teacher->classroom_id;

          $checkAca =  Academic_Year::where('academic_year',$year)
                                    ->where('grade_level',$teacher->grade_level)
                                    ->where('room',$teacher->room)
                                    ->first();

          if($checkAca == null){ // No classroom
            $createAca = new Academic_Year;
            $createAca->academic_year = $year;
            $createAca->grade_level = $teacher->grade_level;
            $createAca->room = $teacher->room;
            $createAca->curriculum_year = $teacher->curriculum_year;
            $createAca->save();
          }


        }
        $this_class_id =  Academic_Year::where('academic_year',$year)
                                    ->where('grade_level',$teacher->grade_level)
                                    ->where('room',$teacher->room)
                                    ->first();


          $addteacher = new Homeroom;
          $addteacher->teacher_id = $teacher->teacher_id;
          $addteacher->classroom_id = $this_class_id->classroom_id;
          $addteacher->save();
        }


      }
      catch(\Exception $e){
         // do task when error
         return response()->json(['Status' => $e->getMessage()], 200);

      }




      return response()->json(['Status' => 'success'], 200);
    }




  // End Teacher


  public function createNewAcademic(Request $request){
    $academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();
    $year = $academic->academic_year;

    try{
      $temp = $academic->replicate();
      $temp->academic_year = $year+1;
      $temp->classroom_id = null;
      $temp->save();

    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }
    return response()->json(['Status' => 'success'], 200);
  }

  public function editSubject(Request $request){
    $openID = $request->input('open_id');
    $checkOpen = Offered_Courses::where('open_course_id',$openID)
                                ->first();
    if($checkOpen == null){
      return response()->json(['Status' => 'This subject does not exist'], 200);
    }
    try{
      $checkOpen = Offered_Courses::where('open_course_id',$openID)
                                  ->update(['semester' =>  $request->input('semester'),
                                            'credits'=>$request->input('credit'),
                                            'is_elective'=>$request->input('elective')]);

    }catch(\Exception $e){
       return response()->json(['Status' => $e->getMessage()], 200);
    }
    return response()->json(['Status' => 'success'], 200);

  }

  public function removeSubject(Request $request){
    $openID = $request->input('open_id');
    $checkOpen = Offered_Courses::where('open_course_id',$openID)
                                ->first();
    if($checkOpen == null){
      return response()->json(['Status' => 'This subject does not exist'], 200);
    }
    try{
      $checkOpen = Offered_Courses::where('open_course_id',$openID)
                                  ->delete();
    }catch(\Exception $e){
       return response()->json(['Status' => $e->getMessage()], 200);
    }
    return response()->json(['Status' => 'success'], 200);

  }

  public function addSubject(Request $request){
    $room = $request->input('room');
    $grade = $request->input('grade');
    $curYear = $request->input('curYear');
    $year = $request->input('year');
    if(!$this->checkAvailableYearRoomLevel($year,$grade,$room)){
      return response()->json(['Status' => "Could not add to this academic year or grade_level/room does not exist"], 200);
    }
    try{
      $semester = (int)$request->input('semester');;
      $credit = (int)$request->input('credit');
    }catch(\Exception $e){
       return response()->json(['Status' => $e->getMessage()], 200);
    }
    if($semester < 1 || $semester > 3){
      return response()->json(['Status' => "Semester could not be : ".$semester], 200);
    }
    if($credit < 0 || $credit > 3){
      return response()->json(['Status' => "Credit could not be : ".$credit], 200);
    }
    //$curYear = Curriculum::orderBy('curriculum_year', 'desc')->groupBy('curriculum_year')->get();
    /*
    $academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();
    $year = $academic->academic_year;
    */
    $checkAca =  Academic_Year::where('academic_year',$year)
                              ->where('grade_level',$grade)
                              ->where('room',$room)
                              ->get();

    if(!isset($checkAca[0])){ // No classroom
      $createAca = new Academic_Year;
      $createAca->academic_year = $year;
      $createAca->grade_level = $grade;
      $createAca->room = $room;
      $createAca->curriculum_year = $curYear;
      $createAca->save();
    }

    $checkAca =  Academic_Year::where('academic_year',$year)
                              ->where('grade_level',$grade)
                              ->where('room',$room)
                              ->first();

    try{
      $checkExist = Offered_Courses::where('classroom_id',$checkAca->classroom_id)
                                        ->where('semester',$request->input('semester'))
                                        ->where('curriculum_year',$curYear)
                                        ->where('course_id',$request->input('course_id'))
                                        ->first();

      if($checkExist != null) return response()->json(['Status' => 'This subject already exists'], 200);



      $createStuClass = new Offered_Courses;
      $createStuClass->classroom_id = $checkAca->classroom_id;
      $createStuClass->semester = $request->input('semester');
      $createStuClass->credits = $request->input('credit');
      $createStuClass->is_elective = $request->input('elective');
      $createStuClass->course_id = $request->input('course_id');
      $createStuClass->curriculum_year = $curYear;
      $createStuClass->save();
    }catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);
    }


    return response()->json(['Status' => 'success'], 200);
  }

  public function importSubFromPrevious(Request $request){
    $year = $request->input('year');


    try{
    if(!$this->checkAvailableYear($year)){
      return response()->json(['Status' => "Academic Year ".$year." could not edit"], 200);
    }
    $subs =  Offered_Courses::where('academic_year',$year-1)
                              ->leftJoin('academic_year','academic_year.classroom_id','offered_courses.classroom_id')
                              ->get();
                              /*
    if($checkAca === null){ // No classroom
      return response()->json(['Status' => 'No previous year student, Can not import', 200]);
    }*/


      $checkSubExistYear =  Offered_Courses::leftJoin('academic_year','offered_courses.classroom_id','academic_year.classroom_id')
                                                ->where('academic_year.academic_year',$year)
                                                ->delete();
    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }

    try{
    $class_temp = -1;
    $this_class_id = null;
    foreach ($subs as $sub) {
      if($class_temp != $sub->classroom_id){
        $class_temp = $sub->classroom_id;

        $checkAca =  Academic_Year::where('academic_year',$year)
                                  ->where('grade_level',$sub->grade_level)
                                  ->where('room',$sub->room)
                                  ->first();

        if($checkAca == null){ // No classroom
          $createAca = new Academic_Year;
          $createAca->academic_year = $year;
          $createAca->grade_level = $sub->grade_level;
          $createAca->room = $sub->room;
          $createAca->curriculum_year = $sub->curriculum_year;
          $createAca->save();
        }
        $this_class_id =  Academic_Year::where('academic_year',$year)
                                    ->where('grade_level',$sub->grade_level)
                                    ->where('room',$sub->room)
                                    ->first();

      }





        $createStuClass = new Offered_Courses;
        $createStuClass->classroom_id = $this_class_id->classroom_id;
        $createStuClass->semester = $sub->semester;
        $createStuClass->credits = $sub->credits;
        $createStuClass->is_elective = $sub->is_elective;
        $createStuClass->course_id = $sub->course_id;
        $createStuClass->curriculum_year = $sub->curriculum_year;
        $createStuClass->save();

      }


    }
    catch(\Exception $e){
       // do task when error
       return response()->json(['Status' => $e->getMessage()], 200);

    }




    return response()->json(['Status' => 'success'], 200);
  }

  public function changeCurYear(Request $request){
    $room = $request->input('room');
    $grade = $request->input('grade');
    $curYear = $request->input('selCur');
    if($curYear === "---"){
      $redi  = "assignSubject/".$grade."/".$room;
      return redirect($redi);
    }
    $academic  = Academic_Year::orderBy('academic_year', 'desc')->groupBy('academic_year')->first();
    $year = $academic->academic_year;

    $checkAca =  Academic_Year::where('academic_year',$year)
                              ->where('grade_level',$grade)
                              ->where('room',$room)
                              ->get();
    if(!isset($checkAca[0])){ // No classroom
      $createAca = new Academic_Year;
      $createAca->academic_year = $year;
      $createAca->grade_level = $grade;
      $createAca->room = $room;
      $createAca->curriculum_year = $curYear;
      $createAca->save();
    }
    else{
      $class_id = $checkAca[0]->classroom_id;
      $temp = Offered_Courses::where('classroom_id',$class_id)->delete();
      $temp = Homeroom::where('classroom_id',$class_id)->delete();
      $temp = Student_Grade_Level::where('classroom_id',$class_id)->delete();

      $checkAca =  Academic_Year::where('academic_year',$year)
                                ->where('grade_level',$grade)
                                ->where('room',$room)
                                ->update(['curriculum_year' => $curYear]);
    }
    $redi  = "assignSubject/".$grade."/".$room;
    return redirect($redi);
  }
}
