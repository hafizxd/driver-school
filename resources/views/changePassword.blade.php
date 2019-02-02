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
                    <label for="password">Ganti Password</label>
                    <input type="password" name="password" placeholder="isikan password..." id="password">
                    <button class="btn btn-primary" type="submit" name="button">Simpan</button>
                  {!! Form::close() !!}


             </div>
         </div>
     </div>
 </div>
@endsection
