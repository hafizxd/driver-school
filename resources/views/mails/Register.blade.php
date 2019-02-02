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
                          Hey {{ $driver->name }}, <br>
                          <p>Selamat karena anda telah menjadi Driver DriverSchool.</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </body>
</html>
