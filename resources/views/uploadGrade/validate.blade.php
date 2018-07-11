<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Validate</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>


  </head>
  <body>
    <h1 style="margin: 25px 50px 75px 100px;">Validate</h1>

    <center>
    <table class="table table-striped table-dark" style="width: 40%;">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Validate</th>
        </tr>
      </thead>
      <tbody>
        @foreach($arrayValidates as $arrayValidate)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $arrayValidate }}</td>
        </tr>
        @endforeach

      </tbody>
    </table>
    <center>

      <div class="row" style="margin-top: 30px; margin-bottom: 30px;">
        <div class="col-5">
        </div>
        <div class="col col-xl-2">
          <button class="btn btn-danger" onclick="window.location.href='/uploadGrade'">Back to Upload</button>
        </div>
      </div>
  </body>
</html>
