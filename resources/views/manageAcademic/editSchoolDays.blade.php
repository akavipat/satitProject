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
<h1>School Days for {{$cur_year}} Academic Year</h1>
<form action="/editSchoolDays/{{$cur_year}}" method="post" id="schooldaytable">
    <input type="hidden" name="update" value="true"/>
    @csrf
    <table class="table table-fit" >
        <thead>
        <tr>
            <th scope="col" rowspan="2">Grade</th>
            <th scope="col" style="text-align: center;" colspan="3">Semester</th>
        </tr>
        <tr>
            <th scope="col">1</th>
            <th scope="col">2</th>
            <th scope="col">3</th>
        </tr>
        </thead>
            <tbody>
            @foreach ($school_days as $grade => $days)
                <tr>
                    <td>{{ $grade}}</td>
                    @for ($sem = 1; $sem <= 3; $sem++)
                        <td>
                            @if(array_key_exists($sem, $days))
                                <input type="number" class="form-control"
                                       name="{{ $grade }}-{{$sem}}"
                                       value="{{ $days[$sem] }}" min="0"
                                       max="365" required>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
            </tbody>
    </table>

</form>

<meta name="csrf-token" content="{{ csrf_token() }}"/>
<div class="container-fluid" >
    <div class="row">
        <div class="col-xs-1"></div>
        <div class="col-xs-3">
            <button class="btn btn-success" type="submit" form="schooldaytable" value="Submit">Save</button>
        </div>
        <div class="col-xs-4">
            <button class="btn btn-primary" onclick="window.location.href='/editAcademic/{{$cur_year}}'">
                Back to edit academic year
            </button>
        </div>
        <div class="col-xs-3">
            <button class="btn btn-primary" onclick="window.location.href='/main'">Back to main</button>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
    } );
</script>