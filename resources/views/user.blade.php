@extends('layouts.app')

@section('title') Pengguna | DriverSchool @endsection

@section('content')
<div class="container">

    {{-- Wrapper Navigation Content --}}
    <div class="tab-content" id="pills-tabContent">

        {{-- Content Pengguna --}}
        <div class="tab-pane fade show active" id="users-tab" role="tabpanel" aria-labelledby="users-tab">
            <div class="row justify-content-center">
                <div class="col-md-10">
                  <a href="/home" class="btn btn-dark" style="margin-bottom:20px;">Beranda</a>
                    <div class="card">
                        <div class="card-header">
                            <h1>
                                Pengguna
                            </h1>
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
                                    <table class="table table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col" width="15%">Avatar</th>
                                                <th scope="col" width="32%">Nama</th>
                                                <th scope="col" width="32%">E-mail</th>
                                                <th scope="col" width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Users as $Key => $User)
                                                <tr>
                                                    <th scope="row">{{ ++$Key }}</th>
                                                    @if(!empty($User->avatar))
                                                      <td><img src="{{asset('storage/blog/' . $User->avatar)}}" style="max-height:34px;max-width:100%;"></td>
                                                    @else
                                                      <td>-</td>
                                                    @endif
                                                    <td>{{ $User->name }}</td>
                                                    <td>{{ $User->email }}</td>
                                                    <td>
                                                        <a href="/user/{{$User->id}}" class="btn btn-dark" style="width:50px;height:24px;padding:0;">Info</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Blokir --}}
                                <div class="tab-pane" id="blokirPengguna-tab">
                                    <table class="table table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="5%">#</th>
                                                <th scope="col" width="15%">Avatar</th>
                                                <th scope="col" width="32%">Nama</th>
                                                <th scope="col" width="32%">E-mail</th>
                                                <th scope="col" width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($UsersBlocked as $Key => $User)
                                                <tr>
                                                    <th scope="row">{{ ++$Key }}</th>
                                                    @if(!empty($User->avatar))
                                                      <td><img src="{{asset('storage/blog/' . $User->avatar)}}" style="max-height:34px;max-width:100%;"></td>
                                                    @else
                                                      <td>-</td>
                                                    @endif
                                                    <td>{{ $User->name }}</td>
                                                    <td>{{ $User->email }}</td>
                                                    <td>
                                                        <a href="/user/{{$User->id}}" class="btn btn-dark" style="width:50px;height:24px;padding:0;">Info</a>
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
        </div>
    </div>
</div>
@endsection
