@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
          <a class="btn btn-primary" href="{{route ('driver')}}" role="button" style="margin-bottom:10px;margin-top:50px;">Back</a>
            <div class="card">
                <div class="card-header">
                  <h2 style="margin:auto;">Profile</h2>
                </div>
                <div class="card-body">
                  <img src="{{asset('storage/blog/1547277835.png')}}" alt="foto-profil" class="rounded-circle" style="width:60%;margin:auto;margin-bottom:10px;display:block;">
                  <h3 style="text-align:center;">{{ $drivers->name }}</h3>
                  <h5 style="text-align:center;">{{ $drivers->email }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
