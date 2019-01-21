@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
          {{--<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-top:40px;">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="btn btn-primary" href="/user">User</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/customer">Customer</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/driver">Driver</a>
                </li>
              </ul>
            </div>
          </nav>--}}
            <div class="card">
              <div class="card-header">
                <h1 style="float:left;margin:auto;">Pengguna</h1>
                  <form action="/user" method="get" class="form-inline" style="float:right;">
                    <div class="form-group">
                      <input name="search" type="text" class="form-control" placeholder="Search user..." id="search" value={{$value}}>
                    </div>
                    <button type="submit" class="btn btn-default" id="ajaxSubmit">Search</button>
                  </form>
              </div>

              <div class="card-body">
                <div class="card-columns">

                  @foreach($user as $users)
                    <div class="card">
                      <div class="card-body" style="margin:0;padding:0;">
                          @if(!empty($users->avatar))
                            <img style="margin:0;" class="card-img-top" src="{{asset('storage/blog/' . $users->avatar)}}" alt="">
                          @endif
                          <h5 class="card-title" style="margin-bottom:3px;margin-top:10px;text-align:center;"><a href="user/{{$users->id}}">{{ $users-> name }}</a></h5>
                      </div>
                    </div>
                  @endforeach

                </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

@section('js')
@endsection
