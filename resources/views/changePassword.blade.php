@extends('layouts.app')

@section('title') Change Password | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Ganti Password</h3>
                </div>
                <div class="card-body">

                  {!! Form::open(['url' => '/change-password/edit', 'method' => 'POST']) !!}
                  {{ Form::token() }}
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <div class="form-group">
                        <input name="password" type="password" class="form-control" placeholder="Isikan password baru">
                    </div>
                    <center>
                        <button class="btn btn-primary" type="submit" name="button">Simpan</button>
                    </center>
                  {!! Form::close() !!}


             </div>
         </div>
     </div>
 </div>
@endsection
