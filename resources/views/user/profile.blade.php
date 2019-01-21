@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                  <a class="btn btn-danger" href="#" role="button">Block</a>
                </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="card-body">
                  <form action="/user/{{$user->id}}/edit" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      @if(!empty($user->avatar))
                        <img src="{{asset('storage/blog/' . $user->avatar)}}" alt="foto-profil" style="width:50%;margin:auto;margin-bottom:10px;display:block;">
                      @endif
                      <input name="avatar" type="file">
                    </div>
                    <div class="form-group">
                      <label>Nama</label>
                      <input name="name" type="text" class="form-control" value="{{ $user->name }}">
                    </div>
                    <div>
                      <label>E-mail</label>
                      <input name="email" type="email" class="form-control" value="{{ $user->email }}">
                    </div>
                    <div>
                      <label style="margin-top:20px;">Alamat</label>
                      <input name="alamat" type="text" class="form-control" value="{{ $user->alamat }}">
                    </div>
                    <input class="btn btn-default" type="submit" name="submit" value="Simpan" style="margin-top:20px;">
                      {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
