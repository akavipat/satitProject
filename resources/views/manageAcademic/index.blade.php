<!-- To be removed --?>

<!-- JQuery -->
<script src="/css/jquery/jquery-3.4.1.min.js"></script>
<!-- Data Table -->
<link rel="stylesheet" type="text/css" href="/css/DataTables/datatables.min.css"/>
<script type="text/javascript" src="/css/DataTables/datatables.min.js"></script>
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

<div class="container">
  <div class="row justify-content-md-center">
    <h1>Manage Academic Year</h1>
  </div>
  <div class="row justify-content-md-center">
    <h4>Current Academic Year is {{$cur_year}}</h4>
  </div>
</div>


<div class="container">
  <div class="row justify-content-md-center setBtn">
      <button class="btn btn-outline-secondary" onclick="window.location.href='/editCurrentAcademic'" type="button">Edit Current Academic Year</button>
  </div>

  <div class="row justify-content-md-center setBtn">
      <button class="btn btn-outline-secondary" type="button" onclick="createNewAcademic()">New Academic Year</button>
  </div>
</div>

<div class="row">
  <div class="col-5">
  </div>
  <div class="col col-lg-3">
    <h4>Once new Academic Year is created, you cannot make change to the past Academic Year</h4>
  </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>

function createNewAcademic(){
  var re = confirm("Are you sure you would like to create new Acadamic Year. You cannot make change to the past Academic Year?");
  if(re == true){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


    $.ajax({
       type:'POST',
       url:'/manageAcademic/createNewAcademic',
       data:{_token: CSRF_TOKEN},
       success:function(data){
         if(data.Status === 'success'){
           alert(data.Status);
          location.reload();
         }
         else{
           alert('fail');
         }
       }
    });

  }
}
</script>
