<!-- JQuery -->
<script src="/css/jquery/jquery-3.4.1.min.js"></script>
<!-- Boot strap -->
<script src="/css/bootstrap/3.3.7/bootstrap.min.js"></script>
<link rel="stylesheet" href="/css/bootstrap/3.3.7/bootstrap.min.css">

<link href="{{ asset('css/studentCSS.css?v='.time()) }}" rel="stylesheet">
<link rel="stylesheet" href="/css/nav.css">


<head>
    <title>Satit Kaset</title>
    <link rel="shortcut icon" href="img/satitLogo.gif"/>
    <div id='cssmenu'>
        <ul>
            <li><a href='/main'>SatitKaset</a></li>
            <li><a href='/manageStudents'>Manage Students</a></li>
            <li><a href='/manageTeachers'>Manage Teachers</a></li>
            <li><a href='/upload'>Upload Grade</a></li>
            <li><a href='/approveGrade'>Approve Grade</a></li>
            <li style="float:right"><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

            <li style="float:right"><a href='#'>{{ auth::user()->firstname.' '.auth::user()->lastname}}</a></li>
        </ul>

    </div>

</head>
<form class="form-inline" id="changeCurYearForm">
    @csrf
    <h1> Manage Academic Year <select class="browser-default custom-select custom-select-lg" onchange="changeYear()"
                                      id="selYear" name="selYear">

            @foreach ($sel_year as $sel_years)
                @if ($cur_year == $sel_years->academic_year)
                    <option selected>{{$sel_years->academic_year}}</option>
                @else
                    <option>{{$sel_years->academic_year}}</option>
                @endif
            @endforeach
        </select>
        <button id="newAcademicYearButton" type="button"  class="btn btn-success">Add new academic
            year
        </button>
    </h1>
</form>

<div class="table-wrapper">
    <table class="table" id="table">
        <thead>
        <tr>
            <th scope="col">Grade</th>
            <th scope="col">Room</th>
            <th scope="col">Teachers</th>
            <th scope="col">Students</th>
            <th scope="col">Courses</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($academicDetail as $detail)
            <tr>
                <td>{{ $detail->grade_level }}</td>
                <td>{{ $detail->room }}</td>
                <td>
                    <button type="button"
                            onclick="window.location.href='/assignTeacher/{{$detail->academic_year}}/{{$detail->grade_level}}/{{$detail->room}}'"
                            class="btn btn-primary">Edit
                    </button>
                </td>
                <td>
                    <button type="button"
                            onclick="window.location.href='/assignStudent/{{$detail->academic_year}}/{{$detail->grade_level}}/{{$detail->room}}'"
                            class="btn btn-primary">Edit
                    </button>
                </td>
                <td>
                    <button type="button"
                            onclick="window.location.href='/assignSubject/{{$detail->academic_year}}/{{$detail->grade_level}}/{{$detail->room}}'"
                            class="btn btn-primary">Edit
                    </button>
                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
</div>

<footer class="page-footer text-center">
    <form class="form-inline">
        <div class="form-group">
            <button type="button"
                    class="btn btn-primary"
                    onclick="window.location.href='/editSchoolDays/{{$cur_year}}'">
                Edit School Days
            </button>
        </div>
        <div class="form-group green_group">
            <label for="selGrade">Adjust rooms for grade :</label>
            <select id="selGrade" class="browser-default custom-select" name="selCur">
                <option selected>1</option>
                @for ($c = 2;$c<=12;$c++)
                    <option>{{$c}}</option>
                @endfor
            </select>
            <button type="button" id="addRoomButton" class="btn btn-primary">Add</button>
            <button type="button" id="removeRoomButton"  class="btn btn-danger">Remove</button>
        </div>

        <div class="form-group orange_group">
            <label>From previous year import all:</label>
            <button type="button" id="importTeachersButton" class="btn btn-info">Teachers</button>
            <button type="button" id="importStudentsButton" class="btn btn-danger">Students</button>
            <button type="button" id="importCoursesButton" class="btn btn-danger">Courses</button>
        </div>
        <div class="form-group">
            @if($active_year != $cur_year)
                <button id="setCurrentAcademicYearButton" class="btn btn-danger">Set as current academic year
                </button>
            @endif
        </div>
    </form>
</footer>

<div class="modal fade" id="Waiting" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="text-align:center;font-size: 60px;">Please Wait Untill Finish</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        </div>
    </div>
</div>


<meta name="csrf-token" content="{{ csrf_token() }}"/>
<script>

    function changeYear() {
        var e = document.getElementById("selYear");
        var strYear = e.options[e.selectedIndex].text;
        window.location.href = "/editAcademic/" + strYear;
    }

    var checkAdd = false;
    $(document).ready(function () {

        $("#addRoomButton").click(function () {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var grade = document.getElementById("selGrade").value;

            $.ajax({
                type: 'POST',
                url: '/manageRoom/add',
                data: {_token: CSRF_TOKEN, grade: grade, year:{{$cur_year}}},
                success: function (data) {
                    alert(data.Status);
                    location.reload();
                }
            });
        });

        $("#removeRoomButton").click(function () {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var grade = document.getElementById("selGrade").value;

            $.ajax({
                type: 'POST',
                url: '/manageRoom/remove',
                data: {_token: CSRF_TOKEN, grade: grade, year:{{$cur_year}}},
                success: function (data) {
                    alert(data.Status);
                    location.reload();
                }
            });
        });

        $("#importTeachersButton").click(function () {
            console.log("Reach here");
            var re = confirm("Are you sure you would like to import teacher from previous year?\n" +
                "All this year teacher data will be deleted before import!!!");
            if (re == true) {
                $("#Waiting").modal({backdrop: 'static', keyboard: false});
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var curr_year = {{$cur_year}}
                $.ajax({
                    type: 'POST',
                    url: '/assignTeacher/importFromPrevious',
                    data: {_token: CSRF_TOKEN, year: curr_year},
                    success: function (data) {
                        $("#Waiting").modal('hide');
                        if (data.Status === 'success') {
                            alert(data.Status);
                        } else {
                            alert(data.Status);
                            //alert('No previous curriculum year!');
                        }
                    }
                });
            }
        });

        $("#importStudentsButton").click(function () {
            var re = confirm("Are you sure you would like to import student from previous year?\nAll this year student data will be deleted before import!!!");
            if (re == true) {
                $("#Waiting").modal({backdrop: 'static', keyboard: false});
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var curr_year = {{$cur_year}}

                $.ajax({
                    type: 'POST',
                    url: '/assignStudent/importFromPrevious',
                    data: {_token: CSRF_TOKEN, year: curr_year},
                    success: function (data) {
                        $("#Waiting").modal('hide');
                        if (data.Status === 'success') {
                            alert(data.Status);
                        } else {
                            alert(data.Status);
                            //alert('No previous curriculum year!');
                        }
                    }
                });
            }
        });

        $("#importCoursesButton").click(function () {
            var re = confirm("Are you sure you would like to import course from previous year?\nAll this year course data will be deleted before import!!!");
            if (re == true) {
                $("#Waiting").modal({backdrop: 'static', keyboard: false});
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var curr_year = $('meta[name="curri_year"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '/assignSubject/importFromPrevious',
                    data: {_token: CSRF_TOKEN, year:{{$cur_year}}},
                    success: function (data) {
                        $("#Waiting").modal('hide');
                        if (data.Status === 'success') {
                            location.reload();
                        } else {
                            alert(data.Status);
                        }
                    }
                });

            }
        });

        $("#setCurrentAcademicYearButton").click(function () {
            var re = confirm("Are you sure you would like to active this academic year?\nYou could not change previous academic year!!!!!");
            if (re == true) {

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '/manageAcademic/activeAcademicYear',
                    data: {_token: CSRF_TOKEN, year:{{$cur_year}}},
                    success: function (data) {
                        if (data.Status === 'success') {
                            alert("Active This Academic year!");
                            location.reload();
                        } else {
                            alert(data.Status);
                        }
                    }
                });
            }
        });

        $("#newAcademicYearButton").click(function () {
            $.ajax({
                type: 'POST',
                url: '/manageAcademic/addNewAca',
                data: {_token: $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data.Status === 'success') {
                        alert("Create new Academic year succeed");
                        location.reload();
                    } else {
                        console.log(data);
                        alert(data.Status);
                    }
                }
            });
        });
    });

</script>
