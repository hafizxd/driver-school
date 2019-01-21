@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
          <a class="btn btn-primary" href="{{route ('customer')}}" role="button" style="margin-bottom:10px;margin-top:50px;">Back</a>
            <div class="card">
                <div class="card-header">
                  <h2 style="margin:auto;">Profile</h2>
                </div>
                <div class="card-body">
                  <img src="{{asset('storage/blog/' . $customers->profile_img)}}" alt="foto-profil" style="width:80%;margin:auto;margin-bottom:10px;display:block;">
                  <h3 style="text-align:center;">{{ $customers->name }}</h3>
                  <h5 style="text-align:center;">{{ $customers->email }}</h5>
                  <span style="margin-top:100px;">Driver : {{ $customers->driver->name }}</span><br>
                  <span>Phone : {{ $customers->phone }} </span><br>
                  <span>User : {{ $customers->user->id }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
