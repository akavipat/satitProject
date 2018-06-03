<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<link href="{{ asset('bootstrap/css/studentCSS.css') }}" rel="stylesheet">
<link rel="stylesheet" href="/css/nav.css">









<head>
  <div id='cssmenu'>
  <ul>
     <li ><a href='/main'>SatitKaset</a></li>
     <li class='active'><a href='#'>Manage Student</a></li>
     <li><a href='/grade'>Grade</a></li>
     <li><a href='#'>About</a></li>
     <li style="float:right">        <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                 {{ __('Logout') }}
             </a>

             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
             </form></li>

             <li style="float:right"><a href='#'>{{ auth::user()->firstname.' '.auth::user()->lastname}}</a></li>
  </ul>

  </div>

</head>

<script>
  $(document).ready(function() {
    $('#table').DataTable();
} );
 </script>


<h1> Manage Students</h1>
<center>
<div class="row" style="width: 120rem;">

    <table class="table table-hover" id="table" style="width: 120rem;">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Subject_Number</th>
          <th scope="col">Subject Name</th>
          <th scope="col">Semester</th>
          <th scope="col">Year</th>
          <th scope="col">Student Number</th>
          <th scope="col">Student Name</th>
          <th scope="col">Score</th>

        </tr>
      </thead>
      <tbody>

        @foreach($gpas as $gpa)

        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $gpa->subj_number   }}</td>
          <td>{{ $gpa->name   }}</td>
          <td>{{ $gpa->semester   }}</td>
          <td>{{ $gpa->year   }}</td>
          <td>{{ $gpa->std_number }}</td>
          <td>{{ $gpa->firstname.' '.$gpa->lastname  }}</td>
          <td>{{ $gpa->score }}</td>
      </td>

        </tr>

        @endforeach


      </tbody>
    </table>
  <!-- </div> -->
</div>

</center>

<div class="row" style="margin-top: 30px; margin-bottom: 30px;">
  <div class="col-5">
  </div>
  <div class="col col-xl-2">
    <button class="btn btn-danger" onclick="window.location.href='/main'">Back to main</button>
  </div>
</div>
