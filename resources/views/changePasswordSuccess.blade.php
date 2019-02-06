@extends('layouts.app')

@section('title') Change Password | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $user->name }}</h3>
                </div>
                <div class="card-body">

                  <p>Selamat, password anda berhasil diganti. Silahkan login kembali pada aplikasi DriverSchool.</p>

             </div>
         </div>
     </div>
 </div>
@endsection
