@extends('layouts.app')

@section('title') Pengguna | DriverSchool @endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-10 mb-3">
        <a class="btn btn-outline-dark" href="/home">Beranda</a> 
        <br>
        <br>
        
        <div class="card">
            <div class="card-header">
                <h1> Pengguna </h1>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" id="user-tab" data-toggle="pill" href="#pegguna-tab" role="tab" aria-controls="pegguna-tab" aria-selected="true">Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="booking-tab" data-toggle="pill" href="#blokirPengguna-tab" role="tab" aria-controls="bookings-tab" aria-selected="false">Blokir</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    {{-- Pengguna --}}
                    <div class="tab-pane show active" id="pegguna-tab" role="tabpanel" aria-labelledby="pegguna-tab">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="10%">#</th>
                                    <th scope="col" width="15%">Avatar</th>
                                    <th scope="col" width="30%">Nama</th>
                                    <th scope="col" width="30%">E-mail</th>
                                    <th scope="col" width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Users as $Key => $User)
                                    <tr>
                                        <th scope="row">{{ ++$Key }}</th>
                                        <td>
                                            @if(!empty($User->avatar))
                                            <img class="img-thumbnail" width="50" src="/img/user/{{ $User->avatar }}" alt="foto profil">
                                            @else
                                                <img class="img-thumbnail" width="50" src="{{ $User->avatar }}" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $User->name }}</td>
                                        <td>{{ $User->email }}</td>
                                        <td>
                                            <a href="/user/{{$User->id}}" class="btn btn-dark" style="width: 100px;">Info</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Blokir --}}
                    <div class="tab-pane" id="blokirPengguna-tab">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($UsersBlocked as $Key => $User)
                                    <tr>
                                        <th scope="row">{{ ++$Key }}</th>
                                        <td>
                                            @if(!empty($User->avatar))
                                            <img class="img-thumbnail" width="50" src="/img/user/{{ $User->avatar }}" alt="foto profil">
                                            @else
                                                <img class="img-thumbnail" width="50" src="{{ $User->avatar }}" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $User->name }}</td>
                                        <td>{{ $User->email }}</td>
                                        <td>
                                            <a href="/user/{{$User->id}}" class="btn btn-dark" style="width: 100px;">Info</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{ $Users->links() }}
  </div>
</div>
@endsection
