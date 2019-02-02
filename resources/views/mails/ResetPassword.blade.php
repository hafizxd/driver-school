<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
  </head>
  <body>
      <div class="container" style="margin-top: 30px;">
          <div class="row justify-content-center">
              <div class="col-6">
                  <div class="card">
                      <div class="card-header">
                          <h3>Driver School</h3>
                      </div>
                      <div class="card-body">
                          Hey {{ $user->name }}, <br>
                          <p>Someone requested a new password for your DriverSchool account.</p>
                          <a class="btn btn-primary" href="{{ url('www.google.com') }}" role="button">Reset Password</a>
                          <br><br>
                          <p>If you didn't make this request then you can safely ignore this email :)</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </body>
</html>
