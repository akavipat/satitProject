<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- add later -->
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">


<link rel="stylesheet" href="/css/nav.css">
<link href="{{ asset('bootstrap/css/studentCSS.css') }}" rel="stylesheet">
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

<h1> Assign Subjects to {{ $grade }}/{{ $room }} {{ $cur_year }} </h1>

<center>
    <div class="row" style="width: 120rem;">
        <div class="form-group">
            <form class="form-inline" action="/assignSubject/changeSelYear" id="changeCurYearForm" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-sm col-form-label text-right">Year :</label>

                </div>
                <div class="col-sm">
                    <select class="form-control" style="height: 30px" name="selCur">
                        <option>---</option>
                        @foreach ($curricula as $curriculum)
                            @if ($selCur === $curriculum->curriculum_year)
                                <option selected>{{$curriculum->curriculum_year}}</option>
                            @else
                                <option>{{$curriculum->curriculum_year}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <input hidden type="text" name="grade" value=' {{$grade}}'>
                <input hidden type="text" name="room" value=' {{$room}}'>
                <input hidden type="text" name="year" value=' {{$cur_year}}'>
                <button type="submit"
                        onclick="return confirm('If you change curriculum year, all subjects will be removed?');"
                        class="btn btn-danger">Change Curriculum Year
                </button>
            </form>


        </div>
        <table class="table table-hover" id="table" style="width: 120rem;">
            <thead>
            <tr>
                <th scope="col">Course ID</th>
                <th scope="col">Course Name</th>
                <th scope="col">Semester</th>
                <th scope="col">In Class</th>
                <th scope="col">Practice</th>
                <th scope="col">Credits</th>
                <th scope="col">Elective</th>
                <th scope="col">Edit</th>
                <th scope="col">Remove</th>

            </tr>
            </thead>
            <tbody>
            <?php $c = 0; ?>
            @foreach ($subs as $sub)
                <?php $c += 1 ?>
                <tr>
                    <td>{{ $sub->course_id }}</td>
                    <td>{{ $sub->course_name }}</td>
                    <td>{{ $sub->semester }}</td>
                    <td>{{ $sub->inclass }}</td>
                    <td>{{ $sub->practice }}</td>
                    <td>{{ $sub->credits }}</td>

                    @if ($sub->is_elective === 1)
                        <td>Yes</td>
                    @else
                        <td>No</td>
                    @endif
                    <td>
                        <button type="button" onclick="" class="btn btn-primary" data-toggle='modal'
                                data-target='#{{$c}}'>
                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger"
                                onclick="removeSubject(''+{{ $sub->open_course_id }});">
                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;Remove
                        </button>
                    </td>

                </tr>



                <!-- Modal -->

                <div class="modal fade" id={{$c}} role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" style="margin-left:10px;">Edit</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>{{$sub->course_name }} {{$sub->course_id }}</p>
                                <form class="form-inline" id="editForm{{$c}}"
                                      onsubmit="editSubject(this.id);return false;" method="post">
                                    @csrf


                                    <input hidden type="text" name="open_id" value='{{ $sub->open_course_id }}'>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Course ID :</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" value='{{ $sub->course_id }}'
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Semester :</label>
                                        <div class="col-sm-5">
                                            <input type="number" class="form-control" name="semester"
                                                   value='{{ $sub->semester }}' min="1" max="3" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">In class :</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="inclass" value='{{ $sub->inclass }}'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Practice :</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="practice" value='{{ $sub->practice }}'>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Credit :</label>
                                        <div class="col-sm-5">
                                            <input type="number" class="form-control" name="credit"
                                                   value='{{ $sub->credits }}' min="0" step="0.5" required
                                                   required>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Elective :</label>
                                        <div class="col-sm-5">
                                            <select name="elective" class="form-control" style="height: 35px">
                                                @if($sub->is_elective == 1)
                                                    <option value="1" selected>Yes</option>
                                                    <option value="0">No</option>
                                                @else
                                                    <option value="1">Yes</option>
                                                    <option value="0" selected>No</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save</button>
                                </form>

                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
    @endforeach

    </tbody>
    </table>
    <!-- </div> -->
    </div>

</center>

<center>
    <div class="modal fade" id="showSub" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="margin-left:10px;">Add Subject</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">


                    <div class="container">
                        <table class="table table-hover" id="tableAddSub" style="width:74rem;">
                            <thead>
                            <tr>
                                <th scope="col">Course ID</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $c = 0; ?>
                            @foreach ($allSub as $sub)
                                <?php $c += 1 ?>
                                <tr>
                                    <td>{{ $sub->course_id }}</td>
                                    <td>{{ $sub->course_name }}</td>
                                    <td><!--
                      <button type="button" class="btn btn-danger" onclick="changeBtn(this.id)"  value="0" id="btnAdd{{ $sub->course_id }}">
                        Not Add
                      </button> -->

                                        <button type="button" class="btn btn-primary" data-toggle='modal'
                                                data-target='#add{{$c}}'>Add
                                        </button>
                                    <!--  <input onclick="changeBtn(this.id)" type="button" value="0" class="btn btn-danger" id="{{ $sub->course_id }}" /> -->
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>

                <!-- <select class="form-control" name="projid" >
                            <option value="Active">Active</option>
                            <option value="Inactive" >Inactive</option>
                            <option value="Graduated" >Graduated</option>
                  </select> -->
                <div class="modal-footer">


                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</center>

<center>

    <?php $c = 0; ?>
    @foreach ($allSub as $sub)
        <?php $c += 1 ?>
        <div class="modal fade" id=add{{$c}} role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="margin-left:10px;">Add Subject</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>{{$sub->course_name }} {{$sub->course_id }}</p>
                        <div class="container">
                            <form class="form-inline" id='form{{$c}}' onsubmit="addSubject({{$c}});return false;">
                                @csrf
                                <input hidden type="text" name="grade" value={{$grade}}>
                                <input hidden type="text" name="room" value={{$room}}>
                                <input hidden type="text" name="year" value={{$cur_year}}>

                                <table class="table table-hover" style="width:74rem;">
                                    <tbody>

                                    <tr>
                                        <td class="text-right" style="width:15rem;">Year :</td>
                                        <td><input type="text" class="form-control" name="curYear"
                                                   value='{{ $sub->curriculum_year }}' readonly></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">Course ID :</td>
                                        <td><input type="text" class="form-control" name="course_id"
                                                   value='{{ $sub->course_id }}' readonly></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">Course Name :</td>
                                        <td><input type="text" class="form-control" name="course_name"
                                                   value='{{ $sub->course_name }}' readonly></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">In Class :</td>
                                        <td><input type="text" class="form-control" name="inclass" ></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">Practice :</td>
                                        <td><input type="text" class="form-control" name="practice" ></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">Semester :</td>
                                        <td><input type="number" class="form-control" name="semester" value="1" min="1"
                                                   max="3" required></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">Credit :</td>
                                        <td><input type="number" class="form-control" name="credit" min="0"
                                                   step=0.5 required></td>
                                    </tr>

                                    <tr>
                                        <td class="text-right">Elective :</td>
                                        <td><select name="elective" class="form-control" style="height: 35px" required>
                                                <option value="1">Yes</option>
                                                <option value="0" selected>No</option>

                                            </select></td>
                                    </tr>


                                    </tbody>
                                </table>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn{{$c}}">Add</button>
                            </form>


                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endforeach

</center>

<center>
    <div class="modal fade" id="AddSub" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="margin-left:10px;">Add Subject</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <form class="form-inline">
                        @csrf
                        <div class="container">
                            <div class="container">

                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-6 col-form-label text-right">Year :</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="year" value='{{$cur_year}}'
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    &nbsp
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-6 col-form-label text-righ">Course ID :</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="course_id"
                                                   placeholder="Enter Subject Code" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    &nbsp
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-sm-6 col-form-label text-righ">Course Name :</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="Enter Subject Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    &nbsp
                                </div>

                            </div>

                        </div>

                </div>

                <!-- <select class="form-control" name="projid" >
                            <option value="Active">Active</option>
                            <option value="Inactive" >Inactive</option>
                            <option value="Graduated" >Graduated</option>
                  </select> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Add Subject</button>
                    </form>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</center>

<center>
    <div class="row" style="margin-top: 30px; margin-bottom: 30px; width: 120rem;">


        <div class="col">
            <button class="btn btn-success" data-toggle='modal' data-target='#showSub'>Add Subject</button>
        </div>


        <div class="col ">
            <button class="btn btn-danger" onclick="window.location.href='/editAcademic/{{$cur_year}}'">Back to edit
                academic year
            </button>
        </div>


        <div class="col ">
            <button class="btn btn-danger" onclick="window.location.href='/main'">Back to main</button>
        </div>

    </div>
</center>

<center>
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
</center>

<meta name="csrf-token" content="{{ csrf_token() }}"/>
<meta name="grade_data" content="{{ $grade }}"/>
<meta name="room_data" content="{{ $room }}"/>


<script>
    var checkAdd = false;
    $(document).ready(function () {

        $('#table').DataTable();
        $('#tableAddSub').DataTable();


        jQuery.noConflict();
        $('#showSub').on('hide.bs.modal', function (e) {
            if (checkAdd) {
                location.reload();
            }
        });
        for (var i = 1; i <= {{sizeof($subs)}}; i++) {
            $('#' + i).on('hide.bs.modal', function (e) {
                if (checkAdd) {
                    location.reload();
                }
            });
        }
        ;
    });

    function removeSubject(id) {


        var open_id = id.replace("remove", "");
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var grade1 = {{$grade}};
        var room1 = {{$room}};
        var re = confirm("Are you sure you would like to remove this subject from " + grade1 + "/" + room1 + "?");
        if (re == true) {
            $.ajax({
                type: 'POST',
                url: '/assignSubject/remove',
                data: {_token: CSRF_TOKEN, open_id: open_id},
                success: function (data) {
                    alert(data.Status);
                    if (data.Status === "success") {
                        location.reload();
                    }
                }
            });
        }
    }

    function addSubject(id) {
        var myForm = $("#form" + id);
        var data = myForm.serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        $.ajax({
            type: 'POST',
            url: '/assignSubject/add',
            data: data,
            success: function (data) {
                if (data.Status == 'success') {
                    checkAdd = true;
                    alert(data.Status);
                }
            }
        });

    }


    function editSubject(id) {


        var myForm = $("#" + id);
        var data = myForm.serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});


        $.ajax({
            type: 'POST',
            url: '/assignSubject/edit',
            data: data,
            success: function (data) {
                if (data.Status == 'success') checkAdd = true;
                alert(data.Status);
            }
        });

    }

    function changeBtn(id) {
        if (document.getElementById(id).value == '0') {
            document.getElementById(id).className = "btn btn-success";
            document.getElementById(id).innerHTML = "Add";
            document.getElementById(id).value = 1;
        } else {
            document.getElementById(id).className = "btn btn-danger";
            document.getElementById(id).innerHTML = "Not Add";
            document.getElementById(id).value = 0;
        }
    }


</script>
