<head>
  <title>Report Card</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>

<center><h4 class="heading">FIRST SEMESTER REPORT</h4></center>
<table class="nameStyle">
    <tr>
      <th scope="col">Student Name</th>
      <th scope="col" colspan="5" class="setCenter">{{ $student->firstname." ".$student->lastname}}</th>
      <th scope="col" class="setLeft">Grade {{ $student->grade_level."/".$student->room}}</th>

    </tr>
</table>


<center>
<table class="table table-bordered tableStyle">
    <tr>
      <th scope="col" rowspan="2">Course</th>
      <th scope="col" rowspan="2">Code</th>
      <th scope="col" rowspan="2">Credit</th>
      <th scope="col" colspan="4" align="center">1st Semester Grade</th>
    </tr>
    <tr>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>Semester Grade</th>
    </tr>
    <?php $i = 1 ;
          $total_credit =0;
    ?>
    @foreach($grade_semester1 as $key => $grade )


    <tr>
      <td>{{$grade['course_name']}}</td>
      <td>{{strtoupper(substr($grade['course_name'], 0, 3))." ".$grade['course_id']}}</td>
      <td>{{ $grade['credits']}}</td>
      <td>{{ $grade['quarter1']}}</td>
      <td>{{ $grade['quarter2']}}</td>
      <td>{{ $grade['quarter3']}}</td>
      <?php
      $grade_total  = $grade['total_point']/3;

      $grade_total = substr($grade_total,0,strpos($grade_total,'.')+3);

       ?>
      <td>{{  $grade_total }}</td>
      <?php $total_credit +=  $grade['credits'] ?>

      <!-- <td>{{ number_format(($grade['quarter1']+$grade['quarter2']+$grade['quarter3'])/3 ,2)}}</td> -->
    </tr>

    @endforeach

    @for ($i = count($grade_semester1); $i < 24; $i++)
    <tr>
      <td></td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
    </tr>
    @endfor



    <tr>
      <th scope="col" colspan="2">Total</th>
      <th scope="col">{{$total_credit}}</th>
      <th scope="col" colspan="3" class="setRight">GPA</th>
      <th scope="col">{{ $avg1 }}</th>
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
      <td>{{ $grade->grade_status_text }}</td>
    </tr>
    @endforeach
    @for ($i = count($activity_semester1); $i < 5; $i++)
    <tr>
      <td> </td>
      <td> </td>

    </tr>
    @endfor


</table>
<p class="classroomStyle">Classroom signature……………..…..…….…………</p>

</center>

<div class="page-break"></div>

<center><h4 class="heading">SECOND SEMESTER REPORT</h4></center>
<table class="nameStyle">
    <tr>
      <th scope="col">Student Name</th>
      <th scope="col" colspan="5" class="setCenter">{{ $student->firstname." ".$student->lastname}}</th>
      <th scope="col" class="setLeft">Grade</th>
    </tr>
</table>


<center>
<table class="table table-bordered tableStyle">
    <tr>
      <th scope="col" rowspan="2">Course</th>
      <th scope="col" rowspan="2">Code</th>
      <th scope="col" rowspan="2">Credit</th>
      <th scope="col" colspan="4" align="center">2nd Semester Grade</th>
    </tr>
    <tr>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>Semester Grade</th>
    </tr>
    <?php $i = 1 ;
          $total_credit =0;
    ?>
    @foreach($grade_semester2 as $key => $grade )


    <tr>
      <td>{{$grade['course_name']}}</td>
      <td>{{strtoupper(substr($grade['course_name'], 0, 3))." ".$grade['course_id']}}</td>
      <td>{{ $grade['credits']}}</td>
      <td>{{ $grade['quarter1']}}</td>
      <td>{{ $grade['quarter2']}}</td>
      <td>{{ $grade['quarter3']}}</td>
      <?php
      $grade_total  = $grade['total_point']/3;
      $grade_total = substr($grade_total,0,strpos($grade_total,'.')+3);
       ?>
      <td>{{  $grade_total }}</td>
      <?php $total_credit +=  $grade['credits'] ?>

      <!-- <td>{{ number_format(($grade['quarter1']+$grade['quarter2']+$grade['quarter3'])/3 ,2)}}</td> -->
    </tr>

    @endforeach


    @for ($i = count($grade_semester2); $i < 24; $i++)
    <tr>
      <td>{{" "." "}}</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    @endfor




    <tr>
      <th scope="col" colspan="2">Total</th>
      <th scope="col">{{$total_credit}}</th>
      <th scope="col" colspan="3" class="setRight">GPA</th>
      <th scope="col">{{$avg2}}</th>
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
      <td>{{ $grade->grade_status_text }}</td>
    </tr>
    @endforeach
    @for ($i = count($activity_semester2); $i < 5; $i++)
    <tr>
      <td>  </td>
      <td>  </td>

    </tr>
    @endfor

</table>
<p class="classroomStyle">Classroom signature……………..…..…….…………</p>

</center>
<div class="page-break"></div>

<center><h4 class="heading">SECOND SEMESTER REPORT</h4></center>
<table class="nameStyle">
    <tr>
      <th scope="col">Student Name</th>
      <th scope="col" colspan="5" class="setCenter">{{ $student->firstname." ".$student->lastname}}</th>
      <th scope="col" class="setLeft">Grade</th>
    </tr>
</table>


<center>
<table class="table table-bordered tableStyle">
    <tr>
      <th scope="col" rowspan="2">Course</th>
      <th scope="col" rowspan="2">Code</th>
      <th scope="col" rowspan="2">Credit</th>
      <th scope="col" colspan="4" align="center">2nd Semester Grade</th>
    </tr>
    <tr>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>Semester Grade</th>
    </tr>
    <?php $i = 1 ;
          $total_credit =0;
    ?>
    @foreach($elective_grades as $key => $elective_grade )


    <tr>
      <td>{{$elective_grade['course_name']}}</td>
      <td>{{strtoupper(substr($elective_grade['course_name'], 0, 3))." ".$elective_grade['course_id']}}</td>
      <td>{{ $elective_grade['credits']}}</td>
      <td>{{ $elective_grade['quarter1']}}</td>
      <td>{{ $elective_grade['quarter2']}}</td>
      <td>{{ $elective_grade['quarter3']}}</td>
      <?php
      $grade_total  = $elective_grade['total_point']/3;

      $grade_total = substr($grade_total,0,strpos($grade_total,'.')+3);

       ?>
      <td>{{  $grade_total }}</td>
      <?php $total_credit +=  $elective_grade['credits'] ?>

      <!-- <td>{{ number_format(($grade['quarter1']+$grade['quarter2']+$grade['quarter3'])/3 ,2)}}</td> -->
    </tr>

    @endforeach

    @for ($i = count($elective_grades); $i < 24; $i++)
    <tr>
      <td></td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
    </tr>
    @endfor



    <tr>
      <th scope="col" colspan="2">Total</th>
      <th scope="col">{{$total_credit}}</th>
      <th scope="col" colspan="3" class="setRight">GPA</th>
      <th scope="col">{{ $elective_grade_avg }}</th>
    </tr>
</table>


<p class="classroomStyle">Classroom signature……………..…..…….…………</p>

</center>

<div class="page-break"></div>

<table class="nameStyle">
    <tr>
      <th scope="col">Student Name</th>
      <th scope="col" colspan="5" class="setCenter">{{ $student->firstname." ".$student->lastname}}</th>
      <th scope="col" class="setLeft">Grade</th>
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
        <td>{{$behavior_record->sem1_q1}}</td>
        <td>{{$behavior_record->sem1_q2}}</td>
        <td>{{$behavior_record->sem2_q1}}</td>
        <td>{{$behavior_record->sem2_q2}}</td>
      </tr>

      @endforeach



  </table>

  <div class="conduct">
    <h6>Conduct Scale</h6>
    <p>4  Excellent</p>
    <p>3  Good</p>
    <p>2  Satisfactory</p>
    <p>1  Needs Improvement</p>
    <p>0  Fail</p>

  </div>
</div>

<h6>Attendance</h6>

<div class="relative2">
  <table class="table table-bordered tableStyle4">
      <tr>
        <td scope="col" rowspan="2">1st Sem Total School Days</td>
        <td scope="col">Present</td>
        <td scope="col">Late</td>
        <td scope="col">Sick</td>
        <td scope="col">Leave</td>
        <td scope="col">Absent</td>
      </tr>
      {{ $check = 0 }}
      @foreach ($attendances as $attendance):
        @if($attendance->semester == 1)
        {{$check =1}}
          <tr>
            <!-- <td>$attendance->present</td> -->
            <td></td>
            <td>{{$attendance->late}}</td>
            <td>{{$attendance->sick}}</td>
            <td>{{$attendance->leave}}</td>
            <td>{{$attendance->absent}}</td>
          </tr>
        @endif
      @endforeach;

      @if($check == 0)
      <tr>
        <!-- <td>$attendance->present</td> -->
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      @endif

      <tr>
        <td scope="col" rowspan="2">2nd Sem Total School Days</td>
        <td scope="col">Present</td>
        <td scope="col">Late</td>
        <td scope="col">Sick</td>
        <td scope="col">Leave</td>
        <td scope="col">Absent</td>
      </tr>
      {{ $check = 0 }}
      @foreach ($attendances as $attendance):
        @if($attendance->semester == 2)
        {{$check =1}}
          <tr>
            <!-- <td>$attendance->present</td> -->
            <td></td>
            <td>{{$attendance->late}}</td>
            <td>{{$attendance->sick}}</td>
            <td>{{$attendance->leave}}</td>
            <td>{{$attendance->absent}}</td>
          </tr>
        @endif
      @endforeach;

      @if($check == 0)
      <tr>
        <!-- <td>$attendance->present</td> -->
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      @endif

  </table>

  <div class="attendance">
    <table>
      <tr>
        <td></td>
        <td>Height (cm.)</td>
        <td>Weight (kg.)</td>
      </tr>
      <tr>
        <td>1st Sem</td>
        <td>{{$physical_record_semester1->height}}</td>
        <td>{{$physical_record_semester1->weight}}</td>
      </tr>
      <tr>
        <td>2nd Sem</td>
        <td>{{$physical_record_semester2->height}}</td>
        <td>{{$physical_record_semester2->weight}}</td>
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
  <p style="margin-left:80px;">  or there is a special reason.</p>
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

<div class="board">
  <div class="dotBottom">
    <center><h4 class="heading">FIRST SEMESTER COMMENT</h4></center> <br>
    <h5>First Comment</h5> <br>
    <h6>Classroom Teacher : ……………..…..…….………………………..…..…….………………………..………………………</h6>
  </div>

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
        <span style="color:white">------</span>/ {{$academic_year}}
      </td>
      </tr>
    </table>
  </div>
  <br>
  <h6>Guardian : ……………..…..…….………………………..…..…….………………………..…………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>

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
        <span style="color:white">------</span>/ {{$academic_year}}
      </td>
      </tr>
    </table>
  </div>
</div>

<div class="page-break"></div>

<div class="board">
  <div class="dotBottom">
    <center><h4 class="heading">FIRST SEMESTER COMMENT</h4></center> <br>
    <h5>Second Comment</h5> <br>
    <h6>Classroom Teacher : ……………..…..…….………………………..…..…….………………………..………………………</h6>
  </div>

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
        <span style="color:white">------</span>/ {{$academic_year}}
      </td>
      </tr>
    </table>
  </div>
  <br>
  <h6>Guardian : ……………..…..…….………………………..…..…….………………………..…………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>

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
        <span style="color:white">------</span>/ {{$academic_year}}
      </td>
      </tr>
    </table>
  </div>
</div>
<div class="page-break"></div>

<div class="board">
  <div class="dotBottom">
    <center><h4 class="heading">SECOND SEMESTER COMMENT</h4></center> <br>
    <h5>First Comment</h5> <br>
    <h6>Classroom Teacher : ……………..…..…….………………………..…..…….………………………..………………………</h6>
  </div>

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
        <span style="color:white">------</span>/ {{$academic_year}}
      </td>
      </tr>
    </table>
  </div>
  <br>
  <h6>Guardian : ……………..…..…….………………………..…..…….………………………..…………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>

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
        <span style="color:white">------</span>/ {{$academic_year}}
      </td>
      </tr>
    </table>
  </div>
</div>

<div class="page-break"></div>

<div class="board">
  <div class="dotBottom">
    <center><h4 class="heading">SECOND SEMESTER COMMENT</h4></center> <br>
    <h5>Second Comment</h5> <br>
    <h6>Classroom Teacher : ……………..…..…….………………………..…..…….………………………..………………………</h6>
  </div>

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
        <span style="color:white">------</span>/ {{$academic_year}}
      </td>
      </tr>
    </table>
  </div>
  <br>
  <h6>Guardian : ……………..…..…….………………………..…..…….………………………..…………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>
  <h6>……………..…..…….………………………..…..…….………………………..………………………………………</h6>

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
        <span style="color:white">------</span>/ {{$academic_year}}
      </td>
      </tr>
    </table>
  </div>
</div>
<div class="page-break"></div>

<h6>Final  Report</h6>
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
    <td style="text-align:left;">First Semester : </td>
    <td>CR</td>
    <td class="dotBottom2">0.00</td>
    <td>CE</td>
    <td class="dotBottom2">0.00</td>
    <td>Sum</td>
    <td class="dotBottom2">#DIV/0!</td>
    <td>GPA</td>
    <td class="dotBottom2">#DIV/0!</td>
  </tr>

  <tr>
    <td style="text-align:left;">Second Semester : </td>
    <td>CR</td>
    <td class="dotBottom2">0.00</td>
    <td>CE</td>
    <td class="dotBottom2">0.00</td>
    <td>Sum</td>
    <td class="dotBottom2">#DIV/0!</td>
    <td>GPA</td>
    <td class="dotBottom2">#DIV/0!</td>
  </tr>

  <tr>
    <th style="text-align:left;">Cumulative :</th>
    <th>CR</th>
    <th class="dotBottom2">0.00</th>
    <th>CE</td>
    <th class="dotBottom2">0.00</th>
    <th>Sum</td>
    <th class="dotBottom2">#DIV/0!</th>
    <th>GPA</td>
    <th class="dotBottom2">#DIV/0!</th>
  </tr>
</table>

<br>
<div class="boxHeader"><h6>Evaluation  :</h6>
<div class="box"></div>

@if($student->grade_level >= 12)
  <div class="boxTail"><p>to be permitted to graduate in academic year {{$academic_year}}</p>

@else
  <div class="boxTail"><p>to be permitted to {{$student->grade_level + 1}} in academic year {{$academic_year}}</p>
@endif



</div>

<div class="boxHeader">
<div class="box"></div>
<div class="boxTail"><p>to be considered.…….………………………..…..…….………………………..….…….……………………</p>
</div>
<br>
<p></p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>

<div>
  <table style="margin-top:20px;">
    <tr>
      <td>.…….………………………..…..…….…………………</td>
      <td style="color:white">-----------------------</td>
      <td>.…….………………………..…..…….……………</td>
    </tr>
    <tr>
      <td style="text-align: center;">Asst.Prof. Acharapan Corvanich</td>
      <td style="color:white">------------------</td>
      <td style="text-align: center;" rowspan="2">Classroom teacher</td>
    </tr>

    <tr>
      <td style="text-align: center;">IP Chair</td>
      <td style="color:white">------------------</td>
    </tr>

    <tr>
      <td style="width:150px; height: 30px; border-bottom: 1px dotted black;text-align: center;">
      /<span style="color:white">------</span>/ {{$academic_year}}
      </td>
      <td></td>
      <td style="width:150px; height: 30px; border-bottom: 1px dotted black;text-align: center;">
      /<span style="color:white">------</span>/ {{$academic_year}}
      </td>
    </tr>

  </table>
</div>
<br><br>
<p>Guardian's Acknowledgement : .…..…….……………………….…….………………………..…..……………………………………….</p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>
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
      <span style="color:white">------</span>/ {{$academic_year}}
    </td>
    </tr>
  </table>
</div>

<br><br>
<p>Remark: .…..…….……………………….…….………………………..…..……………………………………………………………….…</p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>
<p>.…….………………………..…..…….……………………….…….………………………..…..…….………………………………………</p>


<style>
.heading{
  margin-top: 30px;
  margin-bottom: 0px;
}
.setCenter{
  text-align: center;
  border-bottom: 1px dotted black;
  text-decoration: none;
  width: 60%;
  margin-left: 10px;
  margin-right: 10px;
}
.setLeft{
  text-align: left;
}
.setRight{
  text-align: right;
}
.setPosition{
  margin-top: 10px;
  margin-left: 100px;
  font-size: 14px;
  font-weight: bold;
}
.nameStyle{
  width: 100%;
  margin-top: 30px;
}
.tableStyle{
  width: 100%;
  margin-top: 20px;
  border: 1px solid black;
}
.tableStyle2{
  width: 50%;
  margin-top: 20px;
  border: 1px solid black;
}
.tableStyle3{
  width: 70%;
  margin-top: 20px;
  border: 1px solid black;
}
.tableStyle4{
  width: 60%;
  margin-top: 5px;
  border: 1px solid black;
}
.tableStyle5{
  width:50%;
  margin-left:70px;
}
.classroomStyle{
  font-size: 14px;
  position: absolute;
  right: 1px;
  bottom: -50px;
}
.table thead th {
  border-bottom: 1px solid black;
}
.table-bordered th {
    border: 1px solid black;
}
th {
    text-align: center;
    font-size: 12px;
    height: -10px;
}
td {
  font-size: 12px;
  height: -10px;
}
tr {
  height: -10px;
}
.table-bordered td, .table-bordered th {
    border: 1px solid black;
}
.page-break {
    page-break-after: always;
}
.table td, .table th {
    padding: .35rem;
    vertical-align: top;
}
.tableStyle5 th{
  text-align: left;
}
.noGrade p{
  font-size: 10px;
}
.finalReport td{
  text-align: center;
}
p{
  font-size: 12px;
}
h6{
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
    right: 0;
    width: 250px;
}
.board{
  width: 100%;
  height: 97%;
  border-right: 1px solid black;
}
.dotBottom{
  height: 40%;
  border-bottom: 1.5px dotted black;
}
.dotBottom2{
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
</style>
