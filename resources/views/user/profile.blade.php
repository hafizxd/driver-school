@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <a class="btn btn-primary" href="{{route ('user')}}" role="button" style="margin-bottom:50px;">Back</a>
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
                      @if(!empty($user->profile_img))
                        <img src="{{asset('storage/blog/' . $user->profile_img)}}" alt="foto-profil" style="width:80%;margin:auto;margin-bottom:10px;display:block;">
                      @endif
                      <input name="profile_img" type="file">
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
                      <label style="margin-top:20px;">Phone</label>
                      <input name="phone" type="number" class="form-control" value="{{ $user->phone }}">
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
