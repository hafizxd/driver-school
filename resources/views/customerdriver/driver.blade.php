@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
          <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-top:40px;">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="/user">User</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/customer">Customer</a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-primary" href="/driver">Driver</a>
                </li>
              </ul>
            </div>
          </nav>
            <div class="card">
              <div class="card-header">
                <h1 style="float:left;margin:auto;">Drivers</h1>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-condensed">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>E-mail</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-hover table-condensed">
                      @foreach($drivers as $value => $driver)
                        <tr style="padding:0;margin:0;">
                          <td>{{ $value+1 }}</td>
                          <td>{{ $driver->name }}</td>
                          <td>{{ $driver->email }}</td>
                          <td><a class="btn btn-default" href="driver/{{$driver->id}}" role="button">Info</a></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
