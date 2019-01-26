@extends('layouts.app')

@section('title') User Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <a href="/user" class="btn btn-outline-dark" style="margin-bottom:20px;">Back</a>
            <div class="card">
                <div class="card-header">
                  @if($User->role == 0) <a class="btn btn-outline-danger" href="#" role="button">Unblock</a> @endif
                  @if($User->role == 1) <a class="btn btn-outline-danger" href="#" role="button">Block</a> @endif
                </div>
                <div class="card-body">

                  {!! Form::open(['url' => '/user/update', 'method' => 'POST', 'files' => true]) !!}
                  {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $User->id }}">
                    <center>
                        <img class="img-thumbnail" src="/img/user/{{ $User->avatar}}" alt="">
                    </center>
                    <br>
                    <div class="form-group">
                      <input name="avatar" type="file" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                      <label>Nama</label>
                      <input name="name" type="text" class="form-control" value="{{ $User->name }}">
                    </div>
                    <div class="form-group">
                      <label>E-mail</label>
                      <input name="email" type="email" class="form-control" value="{{ $User->email }}">
                    </div>
                    <div class="form-group">
                      <label>Alamat</label>
                      <input name="alamat" type="text" class="form-control" value="{{ $User->alamat }}">
                    </div>
                    <div class="form-group">
                      <label>Phone</label>
                      <input name="phone" type="number" class="form-control" value="{{ $User->phone }}">
                    </div>

                    @foreach($User->childs as $Key => $Child)
                        <div class="form-group">
                          <label>Nama Anak {{++$Key}}</label>
                          <input name="child[{{$Key}}]" type="text" class="form-control" value="{{ $Child->nama }}">
                        </div>
                    @endforeach

                    <div class="text-center">
                        <a href="../" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                    <div class="form-group">
                      <hr width="90%">
                    </div>
                  {!! Form::close() !!}


             </div>
         </div>
     </div>
 </div>
@endsection
