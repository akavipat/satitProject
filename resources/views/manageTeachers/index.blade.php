<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script> -->
<!-- {{ $teachers }} {{$query_fail}}-->

<!-- JQuery -->
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<script src="//code.jquery.com/jquery-1.12.3.js"></script -->
<script src="/css/jquery/jquery-3.4.1.min.js"></script>
<!-- script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script -->

<!-- Data Table -->
<link rel="stylesheet" type="text/css" href="/css/DataTables/datatables.min.css"/>
<script type="text/javascript" src="/css/DataTables/datatables.min.js"></script>


<!-- Boot strap -->
<script src="/css/bootstrap/3.3.7/bootstrap.min.js"></script>
<link rel="stylesheet" href="/css/bootstrap/3.3.7/bootstrap.min.css">

<!-- script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script -->
<!-- add later -->
<!--script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
< script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script >
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" -->
<!-- link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" -->
<link href="{{ asset('css/studentCSS.css?v='.time()) }}" rel="stylesheet">
<link rel="stylesheet" href="/css/nav.css">

<head>
    <title>Satit Kaset</title>
    <link rel="shortcut icon" href="img/satitLogo.gif"/>
    <div id='cssmenu'>
        <ul>
            <li><a href='/main'>SatitKaset</a></li>
            <li><a href='/manageStudents'>Manage Students</a></li>
            <li class='active'><a href='#'>Manage Teachers</a></li>
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

<h1> Manage Teachers</h1>

<?php if ($query_fail != false): ?>
<div class="alert alert-danger">
    <strong>ERROR!</strong> {{$query_fail}}}
</div>
<?php endif; ?>

<div class="table-wrapper">
    <table class="display" id="table" style="width: 100%">
        <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>

        </tr>
        </thead>
        <tbody>
        <?php $c = 0; ?>
        @foreach ($teachers as $teacher)
            <?php $c += 1 ?>
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $teacher->teacher_id }}</td>
                <td>{{ $teacher->name_title }}</td>
                <td>{{ $teacher->firstname }}</td>
                <td>{{ $teacher->lastname }}</td>
                <td>{{ $teacher->teacher_status_text }}</td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#{{$c}}'>Edit
                    </button>
                </td>

            </tr>
            <!-- Modal -->
            <!-- Dialog for editing -->
            <div class="modal fade" id={{$c}} role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="margin-left:10px;">Edit</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="/manageTeachers/update" method="post">
                                @csrf
                                @method('PUT')
                                <input hidden type="text" name="id" value='{{ $teacher->id }}'>
                                <div class="form-group">
                                    <label class="col-form-label">ID:</label>
                                    <input type="text" class="form-control" name="teacher_id"
                                           value='{{ $teacher->teacher_id }}' readonly>
                                    <input hidden type="text" name="teacherID"
                                           value='{{ $teacher->teacher_id }}'>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Title: </label>
                                    <input type="text" class="form-control" name="name_title"
                                           value='{{ $teacher->name_title }}'>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">First name: </label>
                                    <input type="text" class="form-control" name="firstname"
                                           value='{{ $teacher->firstname }}'>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Last name: </label>
                                    <input type="text" class="form-control" name="lastname"
                                           value='{{ $teacher->lastname }}'>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Status:</label>
                                    <select name="status" class="form-control" style="height: 35px">
                                        <?php if ("$teacher->teacher_status_text" == "Active"): ?>
                                        <option value="0" selected>Active</option>
                                        <option value="1">Inactive</option>
                                        <?php endif; ?>

                                        <?php if ("$teacher->teacher_status_text" == "Inactive"): ?>
                                        <option value="0">Active</option>
                                        <option value="1" selected>Inactive</option>
                                        <?php endif; ?>

                                    </select>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                            </form>

                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

        </tbody>
    </table>

    <!-- Modal -->
    <!-- Dialog for Adding -->
    <div class="modal fade" id="adding" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="/manageTeachers/add" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="col-form-label">ID:</label>
                            <input type="text" class="form-control" name="teacherID">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Title: </label>
                            <input type="text" class="form-control" name="name_title">
                        </div>
                        <div class="form-group ">
                            <label class="col-form-label">First name: </label>
                            <input type="text" class="form-control" name="firstname">
                        </div>

                        <div class="form-group ">
                            <label class="col-form-label">Last name: </label>
                            <input type="text" class="form-control" name="lastname">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">Status:</label>
                            <select name="status" class="form-control" style="height: 35px">
                                <option value="0" selected>Active</option>
                                <option value="1">Inactive</option>
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        $('#table').DataTable({
            "dom": '<"toolbar">frtlip'
        });
        $("div.toolbar").html('<button type="button" class="float-left btn btn-success" data-toggle=\'modal\' data-target="#adding">Add</button>');
    });
</script>
