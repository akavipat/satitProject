<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\Student;
use App\Student_Grade_Level;
use App\Academic_Year;
use App\Teacher;
use App\Homeroom;
use App\Grade;
use App\Activity_Record;
use App\Grade_Status;
use App\Physical_Record;
use App\Behavior_Type;
use App\Behavior_Record;
use App\Attendance_Record;
use auth;
  ini_set('max_execution_time', 180);

class ReportCardController extends Controller
{


  public function __construct() {
    $this->middleware('auth');
  }

  public function index2(){
    $academic_years = Academic_Year::groupBy('academic_year')->distinct('academic_year')->orderBy('academic_year')->get();
    $rooms = Academic_Year::orderBy('grade_level')->get();


    return view('reportCard.index2',['academic_years' => $academic_years,'rooms' => $rooms]);

  }
  // public function index(){
  //   $id =  auth::user()->teacher_number;
  //   $teacher = Teacher::where('teacher_id',$id)->select('teachers.*')->get()[0];
  //
  //   $academic_year = Homeroom::where('teacher_id',$teacher->teacher_id)
  //   ->select('homeroom.*')
  //   ->join('academic_year','academic_year.classroom_id','=','homeroom.classroom_id')
  //   ->select('homeroom.*','academic_year.*')
  //   ->get()[0];
  //
  //   $rooms = Academic_Year::where('academic_year',$academic_year->academic_year)
  //   ->select('academic_year.*')
  //   ->get();
  //
  //   // ->join('student_grade_levels','student_grade_levels.classroom_id','academic_year.classroom_id')
  //   // ->select('academic_year.*','student_grade_levels.*')
  //   // ->distinct('student_grade_levels.classroom_id')
  //   // ->get('student_grade_levels.classroom_id');
  //
  //   // $rooms = self::getDistinct($rooms,'classroom_id');
  //
  //
  //
  //
  //
  //
  //
  //   return view('reportCard.master', ['rooms' => $rooms]);
  //
  // }


  public function exportPDF($student_id,$academic_year){

    $grade_level = Student_Grade_Level::where('student_id',$student_id)
    ->select('student_grade_levels.*')
    ->join('academic_year','academic_year.classroom_id','student_grade_levels.classroom_id')
    ->select('student_grade_levels.*','academic_year.*')
    ->first();









    $grade_semester1 = Grade::where('grades.student_id',$student_id)
    ->where('grades.data_status','1')
    ->distinct()
    ->where('grades.semester','1')
    ->where('grades.academic_year' , $academic_year)
    ->join('offered_courses','offered_courses.open_course_id', 'grades.open_course_id')
    // ->where('offered_courses','offered_courses.semester','grades.semester')
    ->where('offered_courses.is_elective','0')
    ->select('grades.*','offered_courses.*')
    ->join('curriculums','curriculums.course_id','offered_courses.course_id')
    ->select('grades.*','offered_courses.*','curriculums.*')
    // ->where('curriculums.curriculum_year','offered_courses.curriculum_year')
    // ->select('grades.*','offered_courses.*','curriculums.*')
    ->get();
    $grade_semester1 = self::getGradeToFrom($grade_semester1);
    $grade_avg_sem1 = self::getAvg($grade_semester1);




    $activity_semester1 = Activity_Record::where('student_id',$student_id)
    ->where('activity_records.data_status','1')
    ->where('activity_records.semester','1')
    ->where('activity_records.academic_year' , $academic_year)
    ->join('offered_courses','offered_courses.open_course_id','activity_records.open_course_id')
      // ->where('offered_courses','offered_courses.semester','grades.semester')
    ->where('offered_courses.is_elective','0')
    ->select('activity_records.*','offered_courses.*')
    ->join('curriculums','curriculums.course_id','offered_courses.course_id')
    // ->where('curriculums.curriculum_year','offered_courses.curriculum_year')
    ->select('activity_records.*','offered_courses.*','curriculums.*')
    ->join('grade_status','grade_status.grade_status','activity_records.grade_status')
    ->select('activity_records.*','offered_courses.*','curriculums.*','grade_status.*')
    ->get();


    $physical_record_semester1 = Physical_Record::where('student_id',$student_id)
    ->where('physical_records.semester','1')
    ->where('physical_records.academic_year' , $academic_year)
    ->select('physical_records.*')
    ->first();




    $grade_semester2 = Grade::where('student_id',$student_id)
    ->where('grades.data_status','1')
    ->distinct()
    ->where('grades.semester','2')
    ->where('grades.academic_year' , $academic_year)
    ->join('offered_courses','offered_courses.open_course_id','grades.open_course_id')
      // ->where('offered_courses','offered_courses.semester','grades.semester')
    ->where('offered_courses.is_elective','0')
    ->select('grades.*','offered_courses.*')
    ->join('curriculums','curriculums.course_id','offered_courses.course_id')
    // ->where('curriculums.curriculum_year','offered_courses.curriculum_year')
    ->select('grades.*','offered_courses.*','curriculums.*')
    ->get();
    $grade_semester2 = self::getGradeToFrom($grade_semester2);
    $grade_avg_sem2 = self::getAvg($grade_semester2);


    $physical_record_semester2 = Physical_Record::where('student_id',$student_id)
    ->where('physical_records.semester','2')
    ->where('physical_records.academic_year' , $academic_year)
    ->select('physical_records.*')
    ->first();





    $activity_semester2 = Activity_Record::where('student_id',$student_id)
    ->where('activity_records.data_status','1')
    ->where('activity_records.semester','2')
    ->where('activity_records.academic_year' , $academic_year)
    ->join('offered_courses','offered_courses.open_course_id','activity_records.open_course_id')
      // ->where('offered_courses','offered_courses.semester','grades.semester')
    ->where('offered_courses.is_elective','0')
    ->select('activity_records.*','offered_courses.*')
    ->join('curriculums','curriculums.course_id','offered_courses.course_id')
    // ->where('curriculums.curriculum_year','offered_courses.curriculum_year')
    ->select('activity_records.*','offered_courses.*','curriculums.*')
    ->join('grade_status','grade_status.grade_status','activity_records.grade_status')
    ->select('activity_records.*','offered_courses.*','curriculums.*','grade_status.*')
    ->get();



    $elective_grades = Grade::where('student_id',$student_id)
    ->where('grades.data_status','1')
    ->distinct()

    ->where('grades.academic_year' , $academic_year)
    ->join('offered_courses','offered_courses.open_course_id','grades.open_course_id')
      // ->where('offered_courses','offered_courses.semester','grades.semester')
    ->where('offered_courses.is_elective','1')
    ->select('grades.*','offered_courses.*')
    ->join('curriculums','curriculums.course_id','offered_courses.course_id')
    // ->where('curriculums.curriculum_year','offered_courses.curriculum_year')
    ->select('grades.*','offered_courses.*','curriculums.*')
    ->get();
    $elective_grades = self::getGradeToFrom($elective_grades);
    $elective_grade_avg = self::getAvg($elective_grades);



    $behavior_records = Behavior_Record::where('student_id',$student_id)
    ->where('behavior_records.academic_year',$academic_year)
    ->where('behavior_records.data_status',1)
    ->select('behavior_records.*')
    ->get();



    $behavior_types = Behavior_Type::all();
    $behavior_records = self::getBehaviorToFrom($behavior_records,$behavior_types);



    $attendances = Attendance_Record::where('data_status',1)
    ->where('attendace_records.student_id',$student_id)
    ->where('attendace_records.academic_year',$academic_year)
    ->select('attendace_records.*')
    ->get();









    $student = Student::where('students.student_id',$student_id)
    ->join('student_grade_levels','student_grade_levels.student_id','students.student_id')
    ->select('students.*','student_grade_levels.*')
    ->join('academic_year','academic_year.classroom_id','student_grade_levels.classroom_id')
    ->select('students.*','student_grade_levels.*','academic_year.*')
    ->first();




    if($grade_level->grade_level <= 6){
        //ยังต้องเปลี่ยนเป็นฟอร์ม 1-6 ถ้าอาจารจะทดสอบให้ทดสอบที่อันนี้ก่อนครับ ผมมีตารางใน seeder แล้วนะครับ ลองseedได้ครับ
      $pdf = PDF::loadView('reportCard.formGrade9-12',['academic_year' => $academic_year,
      'grade_semester1' => $grade_semester1,
      'grade_semester2' => $grade_semester2,
      'student' => $student,
      'avg1' => $grade_avg_sem1,
      'avg2' => $grade_avg_sem2,
      'activity_semester1' => $activity_semester1,
      'activity_semester2' => $activity_semester2,
      'elective_grades' => $elective_grades,
      'elective_grade_avg' => $elective_grade_avg,
      'physical_record_semester1' => $physical_record_semester1,
      'physical_record_semester2' => $physical_record_semester2,
      'attendances' => $attendances,
      'behavior_types' => $behavior_types,
      'behavior_records' => $behavior_records]);

      $pdf->setPaper('a4', 'potrait');
      return $pdf->stream();

    }

    elseif($grade_level->grade_level <= 8){

      $pdf = PDF::loadView('reportCard.formGrade7-8',['academic_year' => $academic_year,
      'grade_semester1' => $grade_semester1,
      'grade_semester2' => $grade_semester2,
      'student' => $student,
      'avg1' => $grade_avg_sem1,
      'avg2' => $grade_avg_sem2,
      'activity_semester1' => $activity_semester1,
      'activity_semester2' => $activity_semester2,
      'elective_grades' => $elective_grades,
      'elective_grade_avg' => $elective_grade_avg,
      'physical_record_semester1' => $physical_record_semester1,
      'physical_record_semester2' => $physical_record_semester2,
      'attendances' => $attendances,
      'behavior_types' => $behavior_types,
      'behavior_records' => $behavior_records]);

      $pdf->setPaper('a4', 'potrait');
      return $pdf->stream();

    }

    elseif($grade_level->grade_level <= 12){

      $pdf = PDF::loadView('reportCard.formGrade9-12',['academic_year' => $academic_year,
      'grade_semester1' => $grade_semester1,
      'grade_semester2' => $grade_semester2,
      'student' => $student,
      'avg1' => $grade_avg_sem1,
      'avg2' => $grade_avg_sem2,
      'activity_semester1' => $activity_semester1,
      'activity_semester2' => $activity_semester2,
      'elective_grades' => $elective_grades,
      'elective_grade_avg' => $elective_grade_avg,
      'physical_record_semester1' => $physical_record_semester1,
      'physical_record_semester2' => $physical_record_semester2,
      'attendances' => $attendances,
      'behavior_types' => $behavior_types,
      'behavior_records' => $behavior_records]);

      $pdf->setPaper('a4', 'potrait');
      return $pdf->stream();

    }



    // return $pdf->download('reportCard.pdf');

  }



  public static function getDistinct($arr,$field){
    $result = array();
    $check = array();



    foreach($arr as $x){

      if (!in_array($x->classroom_id."",$check)){
        array_push($check,$x->classroom_id);
        array_push($result,$x);

      }
    }

    return $result;

  }


  public function Room($classroom_id){

    $room = Academic_Year::where('classroom_id',$classroom_id)
    ->select('academic_year.*')
    ->first();

    $students = Student_Grade_Level::where('classroom_id',$classroom_id)
    ->select('student_grade_levels.*')
    ->join('students','students.student_id','student_grade_levels.student_id')
    ->select('student_grade_levels.*','students.*')
    ->get();
    return view('reportCard.room',['students' =>$students,'room' => $room]);

  }

  public function getBehaviorToFrom($behavior_records,$behavior_types){
      foreach ($behavior_types as $behavior_type) {
        $behavior_type->sem1_q1='';
        $behavior_type->sem1_q2='';
        $behavior_type->sem2_q1='';
        $behavior_type->sem2_q2='';
      }
      foreach ($behavior_types as $behavior_type) {
        foreach ($behavior_records as $behavior_record) {
          if($behavior_type->behavior_type == $behavior_record->behavior_type ){
            if($behavior_record->semester == 1 && $behavior_record->quater ==1 ){
              $behavior_type->sem1_q1=$behavior_record->grade;
            }
            if($behavior_record->semester == 1 && $behavior_record->quater ==2 ){
              $behavior_type->sem1_q2=$behavior_record->grade;
            }
            if($behavior_record->semester == 2 && $behavior_record->quater ==1 ){
              $behavior_type->sem2_q1=$behavior_record->grade;
            }
            if($behavior_record->semester == 2 && $behavior_record->quater ==2 ){
              $behavior_type->sem2_q2=$behavior_record->grade;
            }
          }
          // code...
        }
      }
      return $behavior_types;
  }



  public static function getGradeToFrom($arr){
    $check = array();
    $result = array();

    foreach ($arr as $x ) {
      if (!in_array($x->course_id."",$check)){


        $element = array('course_name'=> $x->course_name,
                        'course_id'=> $x->course_id,
                        'credits'=>$x->credits,
                        'quater1' => 0,
                        'quater2' => 0,
                        'quater3' => 0,
                        'total_point' => 0);

        $element['quater'.$x->quater] = $x->grade;
        $element['total_point'] +=+$x->grade;
        $result[$x->course_id] = $element;
        array_push($check,$x->course_id);



      }else{

        $result[$x->course_id]['quater'.$x->quater] = $x->grade;
        $result[$x->course_id]['total_point'] += $x->grade;

      }

    }


    return $result;

  }





  public static function getAvg($arr){

    $total_score = 0;
    $total_credit = 0;
    foreach ($arr as $key => $x) {
      $score = (($x['total_point']/3)*$x['credits']);
      $score = substr($score,0,strpos($score,'.')+3);
       // $total_score += number_format((($x['total_point']/3)*$x['credits']),2);
      $total_score += $score;
      $total_credit += $x['credits'];
    }
    if($total_credit == 0 ){
      return 0;
    }
    $avg = $total_score/$total_credit;

    return substr($avg,0,strpos($avg,'.')+3);
  }



  public function index(){
    return view('reportCard.master2');
  }

  public function exportForm(){
    $pdf = PDF::loadView('reportCard.form2');
    $pdf->setPaper('a4', 'potrait');
    return $pdf->stream();
  }

  public function exportGrade1(){
    $pdf = PDF::loadView('reportCard.formGrade1-6');
    $pdf->setPaper('a4', 'potrait');
    return $pdf->stream();
  }

  public function exportGrade2(){
    $pdf = PDF::loadView('reportCard.formGrade7-8');
    $pdf->setPaper('a4', 'potrait');
    return $pdf->stream();
  }

  public function exportGrade3(){
    $pdf = PDF::loadView('reportCard.formGrade9-12');
    $pdf->setPaper('a4', 'potrait');
    return $pdf->stream();
  }


}
