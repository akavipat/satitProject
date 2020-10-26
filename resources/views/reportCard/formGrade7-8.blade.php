<head>
    <title>Report Card</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<center><h4 class="heading">FIRST SEMESTER REPORT</h4></center>
<table class="nameStyle">
    <tr>
        <th scope="col">Student Name</th>
        <th scope="col" colspan="5" class="setCenter">{{ $student->firstname." ".$student->lastname}}</th>
        <th scope="col" class="setLeft">Grade {{ $student->grade_level}}</th>

    </tr>
</table>


<center>
    <table class="table table-bordered tableStyle">
        <tr>
            <th scope="col" rowspan="2" class="courseCell" style="border:2px solid black;">Course</th>
            <th scope="col" rowspan="2" class="codeCell"  style="border-bottom:2px solid black;">Code</th>
            <th scope="col" rowspan="2" class="creditCell" style="width: .7cm; border-bottom:2px solid black; border-right:2px solid black;">Credit</th>
            <th scope="col" colspan="4" align="center">1st Semester Grade</th>
        </tr>
        <tr>
            <th class="gradeCell" style="border-bottom:2px solid black;">1</th>
            <th class="gradeCell" style="border-bottom:2px solid black;">2</th>
            <th class="gradeCell" style="border-bottom:2px solid black;">3</th>
            <th class="semCell" style="border-bottom:2px solid black;">Semester Grade</th>
        </tr>
        @foreach($grade_semester1 as $key => $grade )


            <tr>
                <td style="border-right:2px solid black;">{{$grade['course_name']}}</td>
                <td>{{$grade['course_id']}}</td>
                <td class="center-cell" style="border-right:2px solid black;">{{ $grade['credits']}}</td>
                <td class="center-cell">{{ $grade['quarter1']}}</td>
                <td class="center-cell">{{ $grade['quarter2']}}</td>
                <td class="center-cell">{{ $grade['quarter3']}}</td>

                @if($grade['semester_grade'] != "-")
                    <td class="center-cell">{{number_format($grade['semester_grade'],1) }}</td>
                @else
                    <td class="center-cell">{{$grade['semester_grade']}}</td>
                @endif
            </tr>

        @endforeach

        <tr>
            <th scope="col" colspan="2">Total</th>
            <th scope="col" style="border-right:2px solid black;">{{$total_sem1_credit}}</th>
            <th scope="col" colspan="3" class="setRight">GPA</th>
            <th scope="col">{{ $semester_1_gpa }}</th>
        </tr>
    </table>

    <table class="table table-bordered tableStyle2">
        <tr>
            <th scope="col">Activity</th>
            <th scope="col">S/U</th>
        </tr>
        @foreach($activity_semester1 as $grade)
            <tr>
                <td>{{ $grade->course_name }}</td>
                <td class="center-cell">{{ $grade->grade_status_text }}</td>
            </tr>
        @endforeach
        @for ($i = count($activity_semester1); $i < 5; $i++)
            <tr>
                <td></td>
                <td></td>

            </tr>
        @endfor


    </table>
    <p class="classroomStyle">Classroom signature................................................</p>

</center>

<div class="page-break"></div>

<center><h4 class="heading">SECOND SEMESTER REPORT</h4></center>
<table class="nameStyle">
    <tr>
        <th scope="col">Student Name</th>
        <th scope="col" colspan="5" class="setCenter">{{ $student->firstname." ".$student->lastname}}</th>
        <th scope="col" class="setLeft">Grade {{ $student->grade_level}}</th>
    </tr>
</table>


<center>
    <table class="table table-bordered tableStyle">
        <tr>
          <th scope="col" rowspan="2" class="courseCell" style="border:2px solid black;">Course</th>
          <th scope="col" rowspan="2" class="codeCell"  style="border-bottom:2px solid black;">Code</th>
          <th scope="col" rowspan="2" class="creditCell" style="width: .7cm; border-bottom:2px solid black; border-right:2px solid black;">Credit</th>
          <th scope="col" colspan="4" align="center">2nd Semester Grade</th>
        </tr>
        <tr>
          <th class="gradeCell" style="border-bottom:2px solid black;">1</th>
          <th class="gradeCell" style="border-bottom:2px solid black;">2</th>
          <th class="gradeCell" style="border-bottom:2px solid black;">3</th>
          <th class="semCell" style="border-bottom:2px solid black;">Semester Grade</th>
        </tr>
        @foreach($grade_semester2 as $key => $grade )


            <tr>
                <td style="border-right:2px solid black;">{{$grade['course_name']}}</td>
                <td>{{$grade['course_id']}}</td>
                <td class="center-cell"  style="border-right:2px solid black;">{{ $grade['credits']}}</td>
                <td class="center-cell">{{ $grade['quarter1']}}</td>
                <td class="center-cell">{{ $grade['quarter2']}}</td>
                <td class="center-cell">{{ $grade['quarter3']}}</td>

                @if($grade['semester_grade'] != "-")
                    <td class="center-cell">{{number_format($grade['semester_grade'],1) }}</td>
                @else
                    <td class="center-cell">{{$grade['semester_grade']}}</td>
                @endif

            </tr>

        @endforeach

        <tr>
            <th scope="col" colspan="2">Total</th>
            <th scope="col" style="border-right:2px solid black;">{{$total_sem2_credit}}</th>
            <th scope="col" colspan="3" class="setRight">GPA</th>
            <th scope="col">{{$semester_2_gpa}}</th>
        </tr>
    </table>

    <table class="table table-bordered tableStyle2">
        <tr>
            <th scope="col">Activity</th>
            <th scope="col">S/U</th>
        </tr>
        @foreach($activity_semester2 as $grade)
            <tr>
                <td>{{ $grade->course_name }}</td>
                <td class="center-cell">{{ $grade->grade_status_text }}</td>
            </tr>
        @endforeach
        @for ($i = count($activity_semester2); $i < 5; $i++)
            <tr>
                <td></td>
                <td></td>

            </tr>
        @endfor

    </table>
    <p class="classroomStyle">Classroom signature................................................</p>

</center>


<div class="page-break"></div>

<table class="nameStyle">
    <tr>
        <th scope="col">Student Name</th>
        <th scope="col" colspan="5" class="setCenter">{{ $student->firstname." ".$student->lastname}}</th>
        <th scope="col" class="setLeft">Grade {{ $student->grade_level}}</th>
    </tr>
</table>
<p class="setPosition">Social Skills and Personal Conduct</p>

<div class="relative">
    <table class="table table-bordered tableStyle3">
        <tr>
            <th scope="col" rowspan="2">Topic</th>
            <th scope="col" colspan="2">1 Sem.</th>
            <th scope="col" colspan="2">2 Sem.</th>
        </tr>


        <tr>
            <th>1st</th>
            <th>2nd</th>
            <th>1st</th>
            <th>2nd</th>
        </tr>
        @foreach ($behavior_records as $behavior_record)
            <tr>
                <td>{{ $behavior_record->behavior_type_text}}</td>
                <td class="center-cell">{{$behavior_record->sem1_q1}}</td>
                <td class="center-cell">{{$behavior_record->sem1_q2}}</td>
                <td class="center-cell">{{$behavior_record->sem2_q1}}</td>
                <td class="center-cell">{{$behavior_record->sem2_q2}}</td>
            </tr>

        @endforeach


    </table>

    <div class="conduct">
        <h6>Conduct Scale</h6>
        <p>4 Excellent</p>
        <p>3 Good</p>
        <p>2 Satisfactory</p>
        <p>1 Needs Improvement</p>
    </div>
</div>

<h6>Attendance</h6>

<div class="relative2">
    <table class="table table-bordered tableStyle4">
        <tr>
            <th scope="col">1st Sem Total School Days</th>
            <th scope="col">Present</th>
            <th scope="col">Late</th>
            <th scope="col">Sick</th>
            <th scope="col">Leave</th>
            <th scope="col">Absent</th>
        </tr>
        {{ $check = 0 }}
        @foreach ($attendances as $attendance):
        @if($attendance->semester == 1)
            {{$check =1}}
            <tr class="center-cell">
                <td>{{$attendance->total_days}}</td>
                <td>{{$attendance->presence}}</td>
                <td>{{$attendance->late}}</td>
                <td>{{$attendance->sick}}</td>
                <td>{{$attendance->leave}}</td>
                <td>{{$attendance->absent}}</td>
            </tr>
        @endif
        @endforeach;

        @if($check == 0)
            <tr class="center-cell">
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>

        @endif

        <tr>
            <th scope="col">2nd Sem Total School Days</th>
            <th scope="col">Present</th>
            <th scope="col">Late</th>
            <th scope="col">Sick</th>
            <th scope="col">Leave</th>
            <th scope="col">Absent</th>
        </tr>
        {{ $check = 0 }}
        @foreach ($attendances as $attendance):
        @if($attendance->semester == 2)
            {{$check =1}}
            <tr class="center-cell">
                <td>{{$attendance->total_days}}</td>
                <td>{{$attendance->presence}}</td>
                <td>{{$attendance->late}}</td>
                <td>{{$attendance->sick}}</td>
                <td>{{$attendance->leave}}</td>
                <td>{{$attendance->absent}}</td>
            </tr>
        @endif
        @endforeach;

        @if($check == 0)
            <tr class="center-cell">
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>

        @endif

    </table>

    <div class="attendance">
        <table>
            <tr>
                <td></td>
                <td style="text-align: left;">Height (cm.)</td>
                <td>Weight (kg.)</td>
            </tr>
            <tr>
                <td>1st Sem</td>
                @if ($physical_record_semester1)
                    <td class="center-cell">{{$physical_record_semester1->height}}</td>
                    <td class="center-cell">{{$physical_record_semester1->weight}}</td>
                @else
                    <td class="center-cell">-</td>
                    <td class="center-cell"></td>
                @endif
            </tr>
            <tr>
                <td>2nd Sem</td>
                @if ($physical_record_semester2)
                    <td class="center-cell">{{$physical_record_semester2->height}}</td>
                    <td class="center-cell">{{$physical_record_semester2->weight}}</td>
                @else
                    <td class="center-cell">-</td>
                    <td class="center-cell">-</td>
                @endif
            </tr>
        </table>

    </div>
</div>
<h6 class="setPosition">National Standard Grading System</h6>
<table class="tableStyle5">
    <tr>
        <th>Percent (%)</th>
        <th>Grade</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>80 - 100</td>
        <td>4.0</td>
        <td>Excellent</td>
    </tr>
    <tr>
        <td>75 - 79</td>
        <td>3.5</td>
        <td>Very Good</td>
    </tr>
    <tr>
        <td>70 - 74</td>
        <td>3.0</td>
        <td>Good</td>
    </tr>
    <tr>
        <td>65 - 69</td>
        <td>2.5</td>
        <td>Above Average</td>
    </tr>
    <tr>
        <td>60 - 64</td>
        <td>2.0</td>
        <td>Average</td>
    </tr>
    <tr>
        <td>55 - 59</td>
        <td>1.5</td>
        <td>Fair</td>
    </tr>
    <tr>
        <td>50 - 54</td>
        <td>1.0</td>
        <td>Pass</td>
    </tr>
    <tr>
        <td>0 - 49</td>
        <td>0.0</td>
        <td>Fail</td>
    </tr>
</table>

<div class="noGrade">
    <h6>No Grade - Point System</h6>
    <p><span style="font-weight:bold;">I </span><span style="color:white">----</span> Incomplete : Waiting for
        evaluation or evaluation cannot be made because the student has not has not completed assignments,
        taken the exam,</p>
    <p style="margin-left:80px;"> or there is a special reason.</p>
    <p><span style="font-weight:bold;">S</span><span style="color:white">----</span> Satisfactory :
        The student has passed the evaluation criteria by attending at least 80% of the classes,
        and passing the standards set.</p>
    <p><span style="font-weight:bold;">U</span><span style="color:white">----</span> Unsatisfactory :
        The student has not passed the evaluation criteria by not attending at least 80% of the classes,
        and not passing the standards set.</p>
    <p><span style="font-weight:bold;">N/A</span><span style="color:white">-</span> Not Aplicable :
        No information for evaluation</p>

</div>
<div class="page-break"></div>
@for($i = 0 ; $i < 4 ; $i++)

    <div class="board">
        <div class="dotBottom">
<div>
            @if($i <= 1)
                <center><h4 class="heading">FIRST SEMESTER COMMENT</h4></center> <br>
            @else
                <center><h4 class="heading">SECOND SEMESTER COMMENT</h4></center> <br>
            @endif
            @if($i%2 == 0)
                <h5>First Comment</h5> <br>
            @else
                <h5>Second Comment</h5> <br>
            @endif
            <h6>Classroom Teacher :
            </h6>
            @if($teacher_comments[$i] != null)
                <p>{{$teacher_comments[$i]->comment}}</p>
            @endif
        </div>

        <div style="margin-left: 59%;">
            <table style="margin-top:20px;">
                <tr>
                    <th>Signature</th>
                    <th style="width:200px; border-bottom: 1.5px solid black;"></th>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:200px; height: 30px; border-bottom: 1.5px dotted black; text-align: left;">
                        <span style="color:white">---------------</span>/
                        @if($i%2 != 0 && $i > 1)
                        <span style="color:white">------</span>/ 
                        @else
                        <span style="color:white">------</span>/ 
                        @endif

                    </td>
                </tr>
            </table>
        </div>
</div>
        <br>
        <h6>Guardian : <span style="font-size: 14px; font-weight: normal;">...................................................................................................................................................................................</span>
        </h6>
                <p>
                    ........................................................................................................................................................................................................................................</p>

                <p>
                    ........................................................................................................................................................................................................................................</p>
                <p>
                    ........................................................................................................................................................................................................................................</p>
                <p>
                    ........................................................................................................................................................................................................................................</p>

        <div style="margin-left: 59%;">
            <table style="margin-top:20px;">
                <tr>
                    <th>Signature</th>
                    <th style="width:200px; border-bottom: 1.5px solid black;"></th>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:200px; height: 30px; border-bottom: 1.5px dotted black;">
                        <span style="color:white">---------------</span>/
                        @if($i%2 != 0 && $i > 1)
                        <span style="color:white">------</span>/ 
                        @else
                        <span style="color:white">------</span>/ 
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="page-break"></div>
@endfor
<h6>Final Report</h6>
<table style="margin-top:20px; margin-left:40px;" class="finalReport">
    <tr>
        <th><span style="color:white">First Semester : ------</span></th>
        <th><span style="color:white">----------</span></th>
        <th><span style="color:white">----------</span></th>
        <th><span style="color:white">----------</span></th>
        <th><span style="color:white">----------</span></th>
        <th><span style="color:white">----------</span></th>
        <th><span style="color:white">-------------</span></th>
        <th><span style="color:white">----------</span></th>
        <th><span style="color:white">-------------</span></th>
    </tr>
    <tr>
        <td style="text-align:left;">First Semester :</td>
        <td>CR</td>
        <td class="dotBottom2">{{$total_sem1_credit}}</td>
        <td>CE</td>
        <td class="dotBottom2">{{$total_sem1_credit}}</td>
        <td>GPA</td>
        <td class="dotBottom2">{{number_format($semester_1_gpa,2)}}</td>
    </tr>

    <tr>
        <td style="text-align:left;">Second Semester :</td>
        <td>CR</td>
        <td class="dotBottom2">{{$total_sem2_credit}}</td>
        <td>CE</td>
        <td class="dotBottom2">{{$total_sem2_credit}}</td>
        {{--<td>Sum</td>--}}
        {{--<td class="dotBottom2">{{number_format($semester_2_gpa,2)}}</td>--}}
        <td>GPA</td>
        <td class="dotBottom2">{{number_format($semester_2_gpa,2)}}</td>
    </tr>

    <tr>
        <th style="text-align:left;">Cumulative :</th>
        <th>CR</th>
        <th class="dotBottom2">{{$total_credit}}</th>
        <th>CE
        </td>
        <th class="dotBottom2">{{$total_credit}}</th>
        {{--<th>Sum</td>--}}
        {{--<th class="dotBottom2">{{number_format($gpa,2)}}</th>--}}
        <th>GPA
        </td>
        <th class="dotBottom2">{{number_format($gpa,2)}}</th>
    </tr>
</table>

<br>
<div class="boxHeader"><h6>Evaluation :</h6>
    <div class="box"></div>

    @if($student->grade_level >= 12)
        <div class="boxTail"><p>to be permitted to graduate in academic year {{$academic_year}}</p>

            @else
                <div class="boxTail"><p>to be permitted to {{$student->grade_level + 1}} in academic
                        year {{$academic_year+1}}</p>
                    @endif


                </div>

                <div class="boxHeader">
                    <div class="box"></div>
                    <div class="boxTail"><p>to be
                            considered............................................................................................................................................</p>
                    </div>
                    <br><br>
                    <p></p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>

                    <div>
                        <table style="margin-top:20px;">
                            <tr>
                                <td>........................................................</td>
                                <td style="color:white">
                                    ----------------------------------------------------------------------------------------
                                </td>
                                <td>........................................................</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">{{$director_full_name}}</td>
                                <td style="color:white">------------------</td>
                                <td style="text-align: center;" rowspan="2">Classroom teacher</td>
                            </tr>

                            <tr>
                                <td style="text-align: center;">IP Chair</td>
                                <td style="color:white">------------------</td>
                            </tr>

                            <tr>
                                <td style="width:150px; height: 30px; border-bottom: 1px dotted black;text-align: center;">
                                    /<span style="color:white">------</span>/ 
                                </td>
                                <td></td>
                                <td style="width:150px; height: 30px; border-bottom: 1px dotted black;text-align: center;">
                                    /<span style="color:white">------</span>/ 
                                </td>
                            </tr>

                        </table>
                    </div>
                    <br><br>
                    <p>Guardian's Acknowledgement :
                        ..............................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <div style="margin-left: 59%;">
                        <table style="margin-top:20px;">
                            <tr>
                                <th>Signature</th>
                                <th style="width:200px; border-bottom: 1px solid black;"></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="width:200px; height: 30px; border-bottom: 1px dotted black;">
                                    <span style="color:white">---------------</span>/
                                    <span style="color:white">------</span>/ 
                                </td>
                            </tr>
                        </table>
                    </div>

                    <br><br>
                    <p>Remark:
                        ..................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>
                    <p>
                        .................................................................................................................................................................................................................</p>

                    <style>
                        .heading {
                            margin-top: 30px;
                            margin-bottom: 0px;
                        }

                        .setCenter {
                            text-align: center;
                            border-bottom: 1px dotted black;
                            text-decoration: none;
                            width: 60%;
                            margin-left: 10px;
                            margin-right: 10px;
                        }

                        .setLeft {
                            text-align: left;
                        }

                        .setRight {
                            text-align: right;
                        }

                        .setPosition {
                            margin-top: 10px;
                            margin-left: 100px;
                            font-size: 14px;
                            font-weight: bold;
                        }

                        .nameStyle {
                            width: 100%;
                            margin-top: 30px;
                        }

                        .tableStyle {
                            width: 100%;
                            margin-top: 20px;
                        }

                        .tableStyle th {
                            font-size: 9px;
                        }

                        .tableStyle2 {
                            width: 50%;
                            margin-top: 20px;
                            border: 1px solid black;
                        }

                        .tableStyle3 {
                            width: 70%;
                            margin-top: 20px;
                            border: 1px solid black;
                        }

                        .tableStyle4 {
                            width: 60%;
                            margin-top: 5px;
                            border: 1px solid black;
                        }

                        .tableStyle4 th {
                            font-size: 9px;
                        }

                        .tableStyle4 td {
                            font-size: 9px;
                        }

                        .tableStyle5 {
                            width: 50%;
                            margin-left: 70px;
                        }

                        .tableStyle5 th {
                            text-align: left;
                            font-size: 10px;
                        }

                        .tableStyle5 td {
                            font-size: 10px;
                        }

                        .classroomStyle {
                            font-size: 12px;
                            position: absolute;
                            right: 1px;
                            bottom: -50px;
                        }

                        .table-bordered th {
                            border: 1px solid black;
                        }

                        .table-bordered td, .table-bordered th {
                            border: 1px solid black;
                        }

                        .center-cell {
                            text-align: center;
                        }

                        table {
                            border-collapse: collapse;
                        }

                        th {
                            text-align: center;

                            font-size: 11px;
                            height: -10px;
                        }

                        td {
                            font-size: 11px;
                            height: -10px;
                        }

                        tr {
                            height: -10px;
                        }

                        .tableStyle, tr
                        {
                            border:2px solid black;
                        }

                        .page-break {
                            page-break-after: always;
                        }

                        .table td, .table th {
                            padding: .35rem;
                            vertical-align: middle;
                        }

                        .noGrade p {
                            font-size: 10px;
                        }

                        .finalReport td {
                            text-align: center;
                        }

                        p {
                            font-size: 12px;
                        }

                        h6 {
                            font-size: 14px;
                            font-weight: bold;
                            margin-top: 10px;
                            margin-bottom: 10px;
                        }

                        div.relative {
                            position: relative;
                            width: 100%;
                            padding-top: 0%;
                            margin-top: -50px;
                        }

                        div.relative2 {
                            position: relative;
                            width: 100%;
                            padding-top: 0%;
                            margin-top: 0px;
                        }

                        div.conduct {
                            position: absolute;
                            top: 50px;
                            right: 5;
                            width: 150px;
                        }

                        div.attendance {
                            position: absolute;
                            top: 10px;
                            right: -30;
                            width: 250px;
                        }

                        .board {
                            width: 100%;
                            height: 97%;
                            /* border: 1px solid black; */
                        }

                        .dotBottom {
                            height: 40%;
                            border-bottom: 1.5px dotted black;
                        }

                        .dotBottom2 {
                            border-bottom: 1.5px dotted black;
                        }

                        div.boxHeader {
                            position: relative;
                            width: 100%;
                            height: 30px;
                        }

                        div.box {
                            position: absolute;
                            top: 0px;
                            left: 100px;
                            width: 20px;
                            height: 20px;
                            border: 1px solid black;
                        }

                        div.boxTail {
                            position: absolute;
                            top: 0px;
                            left: 130px;
                            width: 80%;
                        }

                        .courseCell {
                            vertical-align: center;
                        }

                        .codeCell {
                            width: 2.2cm;
                            vertical-align: center;
                        }

                        .gradeCell {
                            width: 1cm;
                            vertical-align: center;
                        }

                        .creditCell {
                            width: 1.2cm;
                            vertical-align: center;
                        }

                        .semCell {
                            width: 19mm;
                        }

                        .gradeCell {
                            width: 1cm;
                            vertical-align: center;
                        }

                        .creditCell {
                            width: 1.2cm;
                            vertical-align: center;
                        }

                        .boarderBold{
                          border-bottom: 2px solid black;
                        }
                    </style>
