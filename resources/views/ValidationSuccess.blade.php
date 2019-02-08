@extends('layouts.app')

@section('title') Validation | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $driver->name }}</h3>
                </div>
                <div class="card-body">

                  <p>Selamat, akun anda berhasil dibuat. Silahkan login pada aplikasi DriverSchool.</p>

             </div>
         </div>
     </div>
 </div>
@endsection
