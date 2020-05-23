<?php


namespace App\Http\Controllers;

use App\School_Days;
use App\SystemConstant;
use DB;
use App\Offered_Courses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use PDF;
use App\Student;
use App\Student_Grade_Level;
use App\Academic_Year;
use App\Teacher;
use App\Homeroom;
use App\Grade;
use App\Activity_Record;
use App\Grade_Status;
use App\Information;
use App\Physical_Record;
use App\Behavior_Type;
use App\Behavior_Record;
use App\Attendance_Record;
use App\Teacher_Comment;
use auth;
use File;
use ZipArchive;
use Response;

ini_set('max_execution_time', 720);

// set_time_limit(0);

class ReportCardController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index2()
    {
        $academicYear = Academic_Year::select('academic_year','grade_level','room','classroom_id')
            ->orderBy('academic_year','desc')
            ->orderBy('grade_level','asc')
            ->orderBy('room','asc')->get();

        return view('reportCard.index2',['academicYear' => $academicYear]);
    }

    public function exportPDFAll($classroom_id, $academic_year)
    {
        $students = Student_Grade_Level::where('classroom_id', $classroom_id)
            ->select('student_grade_levels.*')
            ->join('students', 'students.student_id', 'student_grade_levels.student_id')
            ->select('student_grade_levels.*', 'students.*')
            ->get();


        $room = Academic_Year::where('academic_year', $academic_year)
            ->where('classroom_id', $classroom_id)
            ->select('academic_year.*')
            ->first();
        if ($room->room < 10) {
            $folder_name = $room->grade_level . '0' . $room->room . '_' . date("Y-m-d-H-i-s");
        } else {
            $folder_name = $room->grade_level . $room->room . '_' . date("Y-m-d-H-i-s");
        }

        // Create output path for pdf file if it doesn't exists
        $path = public_path() . '/fileToZip' . '/' . $folder_name. '/';
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        // Create output path for zip file if it doesn't exists
        $zip_output_path = public_path() . '/zipPDF'.'/';
        if(!File::exists($zip_output_path)) {
            File::makeDirectory($zip_output_path, $mode = 0777, true, true);
        }

        foreach ($students as $student) {
            self::exportPDF($student->student_id, $academic_year, 1, $folder_name);
        }

//         for($i =0 ; $i < 3;$i ++){
//           self::exportPDF($students[$i]->student_id, $academic_year, 1,$folder_name);
//         }

        // Zip File Name
        $zipFileName = $folder_name . '.zip';

        // Create ZipArchive Obj
        $zip = new ZipArchive;
        if ($zip->open($zip_output_path . $zipFileName, ZipArchive::CREATE) === TRUE) {

            foreach ($students as $student) {
                if($zip->addFile($path . $student->student_id . '.pdf',$student->firstname . "_" . $student->lastname ."_". $student->student_id . '.pdf')){
                 //   Log::info("Adding ".$path . $student->student_id . '.pdf'. " to zip");
                }else{
                    Log::error("Problem adding ".$path . $student->student_id);
                }
            }
//            for($i = 0; $i < 3; $i++){
//                if($zip->addFile($path . $students[$i]->student_id . '.pdf',$students[$i]->student_id . '.pdf')){
//                    Log::info("Adding ".$path . $students[$i]->student_id . '.pdf'. " to zip");
//                }else{
//                    Log::error("Problem adding ".$path . $students[$i]->student_id);
//                }
//            }
            //Log::info("Done adding files to zip");

            $zip->close();
        }else{
            Log::error("Problem open zip file");
        }

        // Set Header
        $headers = array();
        $filetopath = $zip_output_path . $zipFileName;
        //Log::info("Sending ".$filetopath." to users.");
        // Create Download Response
        if ((file_exists($filetopath))) {
            return response()->download($filetopath, $zipFileName, $headers);
        }
    }

    public function exportPDF($student_id, $academic_year, $download_all, $folder_name)
    {
        // Sanity check for security
        // TODO  Need to implement student_id check and $academic_year check to prevent SQL injection


        //SELECT * FROM grades
        //JOIN (
        //    select MAX(datetime) as datetime, `open_course_id`, `quarter`
        //    from `grades` where `student_id` = '2540080850' and `academic_year` = 2018
        //    group by `open_course_id`, `quarter`
        //) as latest_grade
        // ON grades.open_course_id = latest_grade.open_course_id
        //    and grades.quarter = latest_grade.quarter
        //    and grades.datetime = latest_grade.datetime
        //WHERE `student_id` = '2540080850' and `academic_year` = 2018
        //

        // Get the latest grade value by getting the time of the latest valid grades then select
        // the actual grade later by sub join
        $student_latest_grade_keys = Grade::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->where('data_status', 1)
            ->groupBy('open_course_id', 'quarter')
            ->select(DB::raw('MAX(datetime) as datetime'), 'open_course_id', 'quarter');


        $student_latest_grades = Grade::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->joinSub($student_latest_grade_keys, 'latest_grade', function ($join) {
                $join->on('grades.open_course_id', 'latest_grade.open_course_id');
                $join->on('grades.quarter', 'latest_grade.quarter');
                $join->on('grades.datetime', 'latest_grade.datetime');
            })
            ->leftJoin('grade_status', 'grades.grade_status', 'grade_status.grade_status')
            ->select('grades.*', 'grade_status.grade_status_text');

        // Get student grade level and classroom_id

        //SELECT academic_year.grade_level , student_grade_levels.classroom_id
        //FROM student_grade_levels
        //JOIN academic_year ON student_grade_levels.classroom_id = academic_year.classroom_id
        //WHERE academic_year.academic_year = 2018 AND student_grade_levels.student_id="2540080850"
        $grade_level = Student_Grade_Level::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->join('academic_year', 'academic_year.classroom_id', 'student_grade_levels.classroom_id')
            ->select('academic_year.grade_level', 'student_grade_levels.classroom_id')
            ->first();

        //SELECT * FROM offered_courses
        //JOIN curriculums ON curriculums.course_id = offered_courses.course_id
        //LEFT JOIN (SELECT * FROM grades
        //    JOIN (
        //           select MAX(datetime) as datetime, `open_course_id`, `quarter`
        //            from `grades` where `student_id` = '2540080850' and `academic_year` = 2018
        //           group by `open_course_id`, `quarter`
        //        ) as latest_grade
        //        ON grades.open_course_id = latest_grade.open_course_id
        //            and grades.quarter = latest_grade.quarter
        //            and grades.datetime = latest_grade.datetime
        //        WHERE `student_id` = '2540080850' and `academic_year` = 2018)
        //        as student_latest_grades ON offered_courses.classroom_id = student_latest_grades.open_course_id
        //WHERE offered_courses.classroom_id = 7
        //AND curriculums.is_activity = 0
        //AND offered_courses.is_elective = 0

        // Create template for all grade query
        $grade = Offered_Courses::where('classroom_id', $grade_level->classroom_id)
            ->join('curriculums', 'curriculums.course_id', 'offered_courses.course_id')
            ->leftJoinSub($student_latest_grades, 'student_latest_grades', function ($join) {
                $join->on('offered_courses.open_course_id', 'student_latest_grades.open_course_id');
            })
            ->where('curriculums.is_activity', '0')
            ->select('student_latest_grades.quarter', 'student_latest_grades.grade',
                'student_latest_grades.grade_status', 'student_latest_grades.grade_status_text',
                'offered_courses.*', 'curriculums.*')
            ->orderby('curriculums.course_name');


        // Get grade for semester 1
        $grade_semester1_raw = (clone $grade)->where('offered_courses.semester', '1')
            ->where('offered_courses.is_elective', '0')
            ->get();

        $grade_semester1 = self::getGradeToFrom($grade_semester1_raw, $grade_level->grade_level);

        // Get grades for semester 2
        $grade_semester2_raw = (clone $grade)->where('offered_courses.semester', '2')
            ->where('offered_courses.is_elective', '0')
            ->get();
        $grade_semester2 = self::getGradeToFrom($grade_semester2_raw, $grade_level->grade_level);

        // Get elective grades
        $elective_grades = (clone $grade)->where('offered_courses.is_elective', '1')->get();
        $elective_grades = self::getGradeToFrom($elective_grades, $grade_level->grade_level);
        // Get elective with most scores
        $selected_elective = null;
        $top_number_of_grade = 0;
        foreach ($elective_grades as $g) {
            if ($g['grade_count'] > $top_number_of_grade) {
                $selected_elective = $g;
                $top_number_of_grade = $g['grade_count'];
            }
        }

//        $elective_grade_avg = self::getAvg($elective_grades);

        // Get latest activities Use the same technique as grades
        $student_latest_act_keys = Activity_Record::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            //->where('data_status', 1) // TODO Approval of Activity data status is not implemented
            ->groupBy('open_course_id')
            ->select(DB::raw('MAX(datetime) as datetime'), 'open_course_id');

        $student_latest_acts = Activity_Record::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->joinSub($student_latest_act_keys, 'latest_act', function ($join) {
                $join->on('activity_records.open_course_id', 'latest_act.open_course_id');
                $join->on('activity_records.datetime', 'latest_act.datetime');
            })
            ->leftJoin('grade_status', 'activity_records.grade_status', 'grade_status.grade_status')
            ->select('activity_records.*', 'grade_status.grade_status_text');

        // Create template for all activity query
        $acts = Offered_Courses::where('classroom_id', $grade_level->classroom_id)
            ->join('curriculums', 'curriculums.course_id', 'offered_courses.course_id')
            ->leftJoinSub($student_latest_acts, 'student_latest_acts', function ($join) {
                $join->on('offered_courses.open_course_id', 'student_latest_acts.open_course_id');
            })
            ->where('curriculums.is_activity', '1')
            ->select('student_latest_acts.grade_status', 'student_latest_acts.grade_status_text', 'offered_courses.*', 'curriculums.*')
            ->orderby('curriculums.course_name');

        $activity_semester1 = (clone $acts)->where('offered_courses.semester', '1')->get();
        $activity_semester2 = (clone $acts)->where('offered_courses.semester', '2')->get();

        // Get latest comments
        $latest_comment_keys = Teacher_Comment::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            //TODO           ->where('data_status', 1)  // There is no approval system for teacher comment yet
            ->groupBy('semester', 'quarter')
            ->select(DB::raw('MAX(datetime) as datetime'), 'semester', 'quarter');

        $teacher_comments_results = Teacher_Comment::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->joinSub($latest_comment_keys, 'latest_comments', function ($join) {
                $join->on('teacher_comments.semester', 'latest_comments.semester');
                $join->on('teacher_comments.quarter', 'latest_comments.quarter');
                $join->on('teacher_comments.datetime', 'latest_comments.datetime');
            })
            ->select('teacher_comments.*')
            ->orderBy('semester')
            ->orderBy('quarter')
            ->get();
        // Pack comments to skip empty one (in case there is a skip in comment e.g. no comment for semester 1
        $teacher_comments = array_fill(0,
            SystemConstant::TOTAL_SEMESTERS * SystemConstant::TOTAL_QUARTERS,
            null);;
        foreach ($teacher_comments_results as $c){
            // Compute index
            $i = $c->quarter - 1 +
                ($c->semester - 1) * SystemConstant::TOTAL_QUARTERS;
            $teacher_comments[$i] = $c;
        }

        // Get latest physical record
        // TODO no approval for this yet
        $physical_record_semester1 = Physical_Record::where('student_id', $student_id)
            ->where('physical_records.semester', '1')
            ->where('physical_records.academic_year', $academic_year)
            ->select('physical_records.*')
            ->orderBy('datetime', 'desc')
            ->first();

        $physical_record_semester2 = Physical_Record::where('student_id', $student_id)
            ->where('physical_records.semester', '2')
            ->where('physical_records.academic_year', $academic_year)
            ->select('physical_records.*')
            ->orderBy('datetime', 'desc')
            ->first();

        // Get latest Behavior using the same technique as grades
        $latest_behavior_keys = Behavior_Record::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            //TODO           ->where('data_status', 1)  // There is no approval system for behavior  yet
            ->groupBy('semester', 'quarter')
            ->select(DB::raw('MAX(datetime) as datetime'), 'semester', 'quarter');

        $behavior_records = Behavior_Record::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->joinSub($latest_behavior_keys, 'latest_behavior_keys', function ($join) {
                $join->on('behavior_records.semester', 'latest_behavior_keys.semester');
                $join->on('behavior_records.quarter', 'latest_behavior_keys.quarter');
                $join->on('behavior_records.datetime', 'latest_behavior_keys.datetime');
            })
            ->join('behavior_types', 'behavior_records.behavior_type', 'behavior_types.behavior_type')
            ->select('behavior_records.*', 'behavior_types.behavior_type_text')
            ->orderBy('behavior_types.behavior_type_text')
            ->get();

        $behavior_types = Behavior_Type::all();
        $behavior_records = self::getBehaviorToFrom($behavior_records, $behavior_types);


        // Get latest attendance using the same technique as grades
        $latest_att_keys = Attendance_Record::where('student_id', $student_id)
            ->where('academic_year', $academic_year)
            //TODO           ->where('data_status', 1)  // There is no approval system for behavior  yet
            ->groupBy('semester')
            ->select(DB::raw('MAX(datetime) as datetime'), 'semester');

        $attendances = Attendance_Record::where('student_id', $student_id)
            ->where('attendace_records.academic_year', $academic_year)
            ->joinSub($latest_att_keys, 'latest_att_keys', function ($join) {
                $join->on('attendace_records.semester', 'latest_att_keys.semester');
                $join->on('attendace_records.datetime', 'latest_att_keys.datetime');
            })
            ->join('school_days', function ($join) {
                $join->on('school_days.semester', 'attendace_records.semester');
                $join->on('school_days.academic_year', 'attendace_records.academic_year');
            })
            ->where('school_days.grade_level', $grade_level->grade_level)
            ->select('attendace_records.*', 'school_days.total_days','school_days.total_days as presence')
            ->orderBy('semester', 'asc')
            ->get();

        // Subtrace school day if there are attendances record
        foreach ($attendances as $att) {
//            $att->presence -= $att->late;  //Late does not count as absent
            $att->presence -= $att->sick;
            $att->presence -= $att->leave;
            $att->presence -= $att->absent;
        }

        $student = Student::where('students.student_id', $student_id)
            ->where('academic_year', $academic_year)
            ->join('student_grade_levels', 'student_grade_levels.student_id', 'students.student_id')
            ->select('students.*', 'student_grade_levels.*')
            ->join('academic_year', 'academic_year.classroom_id', 'student_grade_levels.classroom_id')
            ->select('students.*', 'student_grade_levels.*', 'academic_year.*')
            ->first();

        $teachers = Homeroom::where('classroom_id', $grade_level->classroom_id)
            ->where('valid', 1)
            ->join('teachers', 'teachers.teacher_id', 'homeroom.teacher_id')
            ->select('name_title', 'firstname', 'lastname')
            ->get();

        $teacher_names = array();
        foreach ($teachers as $t) {
            $teacher_names[] = $t->name_title . " " . $t->firstname . " " . $t->lastname;
        }

        $director_full_name = Information::pluck('director_full_name')[0];

// Pack data for view
        $view_data = ['academic_year' => $academic_year,
            'grade_semester1' => $grade_semester1,
            'grade_semester2' => $grade_semester2,
            'student' => $student,
//            'avg1' => $grade_avg_sem1,
//            'avg2' => $grade_avg_sem2,
            'activity_semester1' => $activity_semester1,
            'activity_semester2' => $activity_semester2,
            'elective_grades' => $elective_grades,
            'selected_elective' => $selected_elective,
//            'elective_grade_avg' => $elective_grade_avg,
            'physical_record_semester1' => $physical_record_semester1,
            'physical_record_semester2' => $physical_record_semester2,
            'attendances' => $attendances,
            'teacher_comments' => $teacher_comments,
            'behavior_types' => $behavior_types,
            'behavior_records' => $behavior_records,
            'teacher_names' => $teacher_names,
            'director_full_name' => $director_full_name];

        // Export to pdf
        PDF::setOptions(['isHtml5ParserEnabled' => true]);
        if ($grade_level->grade_level <= 6) {

            $grade_semester1_6 = self::getGradeToFrom1_6($grade_semester1, $grade_semester2);
            $view_data['grade_semester1'] = $grade_semester1_6;
            $view_data['activity'] = self::getActivityToFrom1_6($activity_semester1,$activity_semester2);
            $view_data = self::computeCumulative($view_data, $grade_level->grade_level);
            $pdf = PDF::loadView('reportCard.formGrade1-6', $view_data);
        } elseif ($grade_level->grade_level <= 8) {
            $view_data = self::computeCumulative($view_data, $grade_level->grade_level);
            $pdf = PDF::loadView('reportCard.formGrade7-8', $view_data);
        } else { //If not it can only be grade 9-12
            $view_data = self::computeCumulative($view_data, $grade_level->grade_level);
            $pdf = PDF::loadView('reportCard.formGrade9-12', $view_data);
        }
        $pdf->setPaper('a4', 'potrait');
        if (!$download_all) {
            return $pdf->stream();
        } else {
            $file_name = $student->student_id;
            $pdf->save(public_path('fileToZip/' . $folder_name . '/' . $file_name . '.pdf', true));

        }
    }


    public
    static function getDistinct($arr, $field)
    {
        $result = array();
        $check = array();


        foreach ($arr as $x) {

            if (!in_array($x->classroom_id . "", $check)) {
                array_push($check, $x->classroom_id);
                array_push($result, $x);

            }
        }

        return $result;

    }


    public
    function Room($classroom_id)
    {

        $room = Academic_Year::where('classroom_id', $classroom_id)
            ->select('academic_year.*')
            ->first();

        $students = Student_Grade_Level::where('classroom_id', $classroom_id)
            ->select('student_grade_levels.*')
            ->join('students', 'students.student_id', 'student_grade_levels.student_id')
            ->select('student_grade_levels.*', 'students.*')
            ->get();
        return view('reportCard.room', ['students' => $students, 'room' => $room]);

    }

    public
    function getBehaviorToFrom($behavior_records, $behavior_types)
    {
        foreach ($behavior_types as $behavior_type) {
            $behavior_type->sem1_q1 = '';
            $behavior_type->sem1_q2 = '';
            $behavior_type->sem2_q1 = '';
            $behavior_type->sem2_q2 = '';
        }
        foreach ($behavior_types as $behavior_type) {
            foreach ($behavior_records as $behavior_record) {
                if ($behavior_type->behavior_type == $behavior_record->behavior_type) {
                    if ($behavior_record->semester == 1 && $behavior_record->quarter == 1) {
                        $behavior_type->sem1_q1 = $behavior_record->grade;
                    }
                    if ($behavior_record->semester == 1 && $behavior_record->quarter == 2) {
                        $behavior_type->sem1_q2 = $behavior_record->grade;
                    }
                    if ($behavior_record->semester == 2 && $behavior_record->quarter == 1) {
                        $behavior_type->sem2_q1 = $behavior_record->grade;
                    }
                    if ($behavior_record->semester == 2 && $behavior_record->quarter == 2) {
                        $behavior_type->sem2_q2 = $behavior_record->grade;
                    }
                }

            }
        }
        return $behavior_types;
    }


    // This method set up grade into a form ready for report card
    // Also compute semester grade of each subject
    public
    static function getGradeToFrom($arr, $grade_level)
    {
        $result = array();
        foreach ($arr as $x) {
            if (!array_key_exists($x->course_id, $result)) {

                $element = array('course_name' => $x->course_name,
                    'course_id' => $x->course_id,
                    'credits' => $x->credits,
                    'inclass' => $x->inclass,
                    'practice' => $x->practice,
                    'quarter1' => "",
                    'quarter2' => "",
                    'quarter3' => "",
                    'semester_grade' => 0,
                    'grade_count' => 0);

                $result[$x->course_id] = $element;
            } else {
                $element = $result[$x->course_id];
            }

            switch ($x->grade_status) {
                case SystemConstant::NO_GRADE:
                    $element['quarter' . $x->quarter] = "";
                    break;
                case SystemConstant::HAS_GRADE:
                    $element['quarter' . $x->quarter] = $x->grade;
                    $element['semester_grade'] += $x->grade;
                    // Only count when this is not final quarter
                    if ($x->quarter < SystemConstant::FINAL_Q) {
                        $element['grade_count']++;
                    }
                    break;
                case SystemConstant::PASS_I_GRADE:
                    $element['quarter' . $x->quarter] = "I/" . $x->grade;
                    $element['semester_grade'] += $x->grade;
                    // Only count when this is not final quarter
                    if ($x->quarter < SystemConstant::FINAL_Q) {
                        $element['grade_count']++;
                    }
                    break;
                case SystemConstant::DROP_GRADE:
                    // Set credit to zero to drop class from student record
                    $element['credits'] = 0;
                    $element['quarter' . $x->quarter] = $x->grade_status_text;
                    break;
                default:
                    $element['quarter' . $x->quarter] = $x->grade_status_text;
                    $element['semester_grade'] += $x->grade;
                    if ($x->quarter < SystemConstant::FINAL_Q) {
                        $element['grade_count']++;
                    }
            }
            $result[$x->course_id] = $element;
        }

        // Change semester to "-" when one of the quarters is missing
        // otherwise compute semester grade normally
        foreach ($result as $key => $x) {
            if ($x['credits'] == 0 || $x['grade_count'] < 1) {
                // Drop class from result if there is a drop status
                // (signalled by credit being set to 0)
                // or grade count is zero
                unset($result[$key]);
            } else {
                if ($x['grade_count'] != SystemConstant::TOTAL_QUARTERS) {
                    $x['semester_grade'] = "-";

                } else {
                    if ($x['quarter' . SystemConstant::FINAL_Q] === "") {
                        // There is no final just average grade without
                        $grade = $x['semester_grade'] / SystemConstant::TOTAL_QUARTERS;
                    } else {
                        $grade = $x['semester_grade'] / (SystemConstant::TOTAL_QUARTERS + 1);
                    }
                    if($grade_level < 7) {
                        $x['semester_grade'] = round($grade, 1);
                    }else{
                        $x['semester_grade'] = self::academic_evaluation_cart_2($grade);
                    }
                }
                $result[$key] = $x;
            }
        }

        return $result;

    }


    // This takes $grade_sem1 and $grade_sem2 that is output from getGradeToFrom method
    public
    static function getGradeToFrom1_6($grade_sem1, $grade_sem2)
    {
        $result = array();

        // Combine two grades into one and compute year grade
        foreach ($grade_sem1 as $course_id => $s1) {
            if(array_key_exists($course_id,$grade_sem2)){
                $s2 = $grade_sem2[$course_id];
            }else{
                $s2 = null;
            }

            $grade['course_name'] = $s1['course_name'];
            $grade['course_id'] = $s1['course_id'];
            $grade['credits'] = $s1['credits'];
            $grade['inclass'] = $s1['inclass'];
            $grade['practice'] = $s1['practice'];
            for ($i = 1; $i <= SystemConstant::TOTAL_QUARTERS + 1; $i++) {
                $grade['quarter' . $i . '_sem1'] = $s1['quarter' . $i];
                if($s2 != null) {
                    $grade['quarter' . $i . '_sem2'] = $s2['quarter' . $i];
                }else{
                    $grade['quarter' . $i . '_sem2'] = "";
                }
            }
            $grade['semester1_grade'] = $s1['semester_grade'];
            if($s2 != null) {
                $grade['semester2_grade'] = $s2['semester_grade'];
            }else{
                $grade['semester2_grade'] = "-";
            }

            // Compute year grade when possible
            if ($grade['semester1_grade'] != "-" && $grade['semester2_grade'] != "-") {
                $grade['year_grade'] = self::academic_evaluation_cart_2(
                    ($grade['semester1_grade'] + $grade['semester2_grade']) / 2);
            } else {
                $grade['year_grade'] = '-';
            }

            $result[$course_id] = $grade;
        }

        return $result;

    }

    private static function getActivityToFrom1_6($activity_sem1,$activity_sem2){
        $activity = array();

        // Create look up for activity semester 2
        $activity_sem2_lookup = array();
        foreach ($activity_sem2 as $grade){
            $activity_sem2_lookup[$grade->course_id] = $grade;
        }

        foreach ($activity_sem1 as $grade){
            $grade->sem_1_grade_status_text = $grade->grade_status_text;
            if(array_key_exists($grade->course_id, $activity_sem2_lookup)){
                $grade->sem_2_grade_status_text = $activity_sem2_lookup[$grade->course_id]->grade_status_text;
            }
            $activity[] = $grade;
        }
        return $activity;
    }

    public
    function index()
    {
        return view('reportCard.master2');
    }

    public
    function exportForm()
    {
        $pdf = PDF::loadView('reportCard.form2');
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public
    function exportGrade1()
    {
        $pdf = PDF::loadView('reportCard.formGrade1-6');
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public
    function exportGrade2()
    {
        $pdf = PDF::loadView('reportCard.formGrade7-8');
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public
    function exportGrade3()
    {
        $pdf = PDF::loadView('reportCard.formGrade9-12');
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    /* Compute cumulative stats such as GPA, Semester GPA, CR, CE*/
    public
    function computeCumulative($view_data, $grade_level)
    {
        $total_credit = 0; // CR CE
        $total_sem1_credit = 0;
        $total_sem2_credit = 0;
        $semester_1_gpa = 0;
        $semester_2_gpa = 0;
        $gpa = 0;

        // Semester 1 computation
        foreach ($view_data['grade_semester1'] as $key => $g) {
            $credit = $g['credits'];
            $total_sem1_credit += $credit;
            if ($grade_level <= 6) {
                $semester_grade = $g['semester1_grade'];
            } else {
                $semester_grade = $g['semester_grade'];
            }
            if ($semester_grade != "-") {
                if ($grade_level <= 6) {
                    // For grade 1-6
                    $year_grade = $g['year_grade'];
                    if ($year_grade != "-") {
                        $gpa += $year_grade * $credit;
                    }
                }
                $semester_1_gpa += $semester_grade * $credit;
            }
        }

        $total_credit += $total_sem1_credit;
        if ($grade_level <= 6) {
            if ($total_sem1_credit < SystemConstant::MIN_TO_ZERO) {
                $gpa = 0;
            } else {
                //$gpa = round($gpa / $total_sem1_credit, 2);
                /*  Method changed on 23/5/2020  The rounding will 
                    be round off same as higher year.  The
                    rounding off is assumed to be execute below 
                    before returning value.  At the time of writing is at
                    line 819 */
                $gpa = $gpa / $total_sem1_credit;
            }
        } else {
            $gpa = $semester_1_gpa;
        }

        if ($total_sem1_credit < SystemConstant::MIN_TO_ZERO) {
            $semester_1_gpa = 0;
        } else {
            $semester_1_gpa = $semester_1_gpa / $total_sem1_credit;
        }

        // Semester 2 computation
        foreach ($view_data['grade_semester2'] as $key => $g) {

            $credit = $g['credits'];
            $total_sem2_credit += $credit;
            $grade = $g['semester_grade'];
            if ($grade != "-") {
//                if($grade_level <= 6){
//                    $semester_2_gpa += $grade;
//                    $total_sem2_subject++;
//                }else {
                $semester_2_gpa += $grade * $credit;
//                }
            }
        }

        // Grade 1-6 already double count credits so there is
        // no need to add more to total credit
        //  Moreover Grade 1-6 already computed GPA from semester 1 computation
        if ($grade_level > 6) {
            if ($grade_level < 9) {  // Grade 7-8
                $total_credit += $total_sem2_credit;
            } else {  // Grade 9-12

                // Add selected elective
                $credit = $view_data['selected_elective']['credits'];
                $total_sem2_credit += $credit;
                $semester_grade = $view_data['selected_elective']['semester_grade'];
                if ($semester_grade != "-") {
                    $semester_2_gpa += $semester_grade * $credit;
                }
                $total_credit += $total_sem2_credit;
            }
            $gpa += $semester_2_gpa;

            if ($total_sem2_credit < SystemConstant::MIN_TO_ZERO) {
                $semester_2_gpa = 0;
            } else {
                //$semester_2_gpa = round($semester_2_gpa / $total_sem2_credit, 2);
                $semester_2_gpa = $semester_2_gpa / $total_sem2_credit;
            }
            if ($total_credit < SystemConstant::MIN_TO_ZERO) {
                $gpa = 0;
            } else {
                $gpa /= $total_credit;
            }
        }

        if($grade_level <=6){
            // total subject in semester 1 and 2 should be equal
            if ($total_sem1_credit < SystemConstant::MIN_TO_ZERO) {
                $semester_2_gpa = 0;
            }else{
                $semester_2_gpa = $semester_2_gpa / $total_sem1_credit;
            }
        }else {

        }

        // Properly round gpas
        $semester_1_gpa = floor($semester_1_gpa * 100 ) / 100;
        $semester_2_gpa = floor($semester_2_gpa * 100 ) / 100;
        $gpa = floor($gpa * 100 ) / 100;

        // Pack data back to view_data
        $view_data['gpa'] = $gpa;
        $view_data['semester_1_gpa'] = $semester_1_gpa;
        $view_data['semester_2_gpa'] = $semester_2_gpa;
        $view_data['total_sem1_credit'] = $total_sem1_credit;
        $view_data['total_sem2_credit'] = $total_sem2_credit;
        $view_data['total_credit'] = $total_credit;
        return $view_data;
    }

    // This method take floating grade number from 0.0 to 4.0 and output
    // Grade according to academic evaluation chart 2
    // The input is expected to be a float.
    static public function academic_evaluation_cart_2($grade){
        // Round number to two decimal points
        $grade = round($grade, 2);
        if ($grade < 1.00) {
            return 0;
        } elseif ($grade < 1.25) {
            return 1;
        } elseif ($grade < 1.75) {
            return 1.5;
        } elseif ($grade < 2.25) {
            return 2;
        } elseif ($grade < 2.75) {
            return 2.5;
        } elseif ($grade < 3.25) {
            return 3;
        } elseif ($grade < 3.75) {
            return 3.5;
        }

        return 4;
    }
}
