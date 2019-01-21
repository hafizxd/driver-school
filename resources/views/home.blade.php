@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- List Navigation --}}
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="user-tab" data-toggle="pill" href="#users-tab" role="tab" aria-controls="users-tab" aria-selected="true">Pelanggan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="driver-tab" data-toggle="pill" href="#drivers-tab" role="tab" aria-controls="drivers-tab" aria-selected="false">Supir</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/langganan">Langganan</a>
                </li>
            </ul>
        </div>
    </div>


    {{-- Wrapper Navigation Content --}}
    <div class="tab-content" id="pills-tabContent">

        {{-- Content Pengguna --}}
        <div class="tab-pane fade show active" id="users-tab" role="tabpanel" aria-labelledby="users-tab">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h1>
                                Pelanggan
                            </h1>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" id="user-tab" data-toggle="pill" href="#pegguna-tab" role="tab" aria-controls="pegguna-tab" aria-selected="true">Pelanggan</a>
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
                                                <th scope="col" width="3%">#</th>
                                                <th scope="col" width="11%">Avatar</th>
                                                <th scope="col" width="25%">Nama</th>
                                                <th scope="col" width="25%">E-mail</th>
                                                <th scope="col" width="25%">Phone</th>
                                                <th scope="col" width="11%">Action</th>
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
                                                    <td>{{ $User->phone }}</td>
                                                    <td>
                                                        <a href="/pelanggan/{{$User->id}}" class="btn btn-dark" style="width:50px;height:24px;padding:0;">Info</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Blokir --}}
                                <div class="tab-pane" id="blokirPengguna-tab">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                {{--<th scope="col" width="10%">#</th>
                                                <th scope="col" width="40%">Nama</th>
                                                <th scope="col" width="30%">E-mail</th>
                                                <th scope="col" width="20%">Action</th>--}}

                                                <th scope="col" width="3%">#</th>
                                                <th scope="col" width="11%">Avatar</th>
                                                <th scope="col" width="25%">Nama</th>
                                                <th scope="col" width="25%">E-mail</th>
                                                <th scope="col" width="25%">Phone</th>
                                                <th scope="col" width="11%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($UsersBlocked as $Key => $User)
                                                <tr>
                                                    <th scope="row">{{ ++$Key }}</th>
                                                    @if(!empty($User->avatar))
                                                      <td><img src="{{asset('storage/blog/' . $User->avatar)}}" style="width:50%;"></td>
                                                    @else
                                                      <td>-</td>
                                                    @endif
                                                    <td>{{ $User->name }}</td>
                                                    <td>{{ $User->email }}</td>
                                                    <td>{{ $User->phone }}</td>
                                                    <td>
                                                        <a href="/pelanggan/{{$User->id}}" class="btn btn-dark" style="width:50px;height:24px;padding:0;">Info</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a style="font-weight:bold;font-size:23px;"  href="/pelanggan">More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content Supir --}}
        <div class="tab-pane fade" id="drivers-tab" role="tabpanel" aria-labelledby="drivers-tab">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h1>
                                Supir
                            </h1>
                        </div>
                        <div class="card-body">

                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" id="user-tab" data-toggle="pill" href="#supir-tab" role="tab" aria-controls="supir-tab" aria-selected="true">Supir</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="booking-tab" data-toggle="pill" href="#blokirSupir-tab" role="tab" aria-controls="blokirSupir-tab" aria-selected="false">Blokir</a>
                                </li>
                            </ul>
                            <br>

                            <div class="tab-content">
                                {{-- Supir --}}
                                <div class="tab-pane show active" id="supir-tab" role="tabpanel" aria-labelledby="supir-tab">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                              <th scope="col" width="3%">#</th>
                                              <th scope="col" width="11%">Avatar</th>
                                              <th scope="col" width="25%">Nama</th>
                                              <th scope="col" width="25%">E-mail</th>
                                              <th scope="col" width="25%">Phone</th>
                                              <th scope="col" width="11%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Drivers as $Key =>  $Driver)
                                                <tr>
                                                    <th scope="row">{{ ++$Key }}</th>
                                                    @if(!empty($Driver->avatar))
                                                      <td><img src="{{asset('storage/blog/' . $User->avatar)}}" style="width:50%;"></td>
                                                    @else
                                                      <td>-</td>
                                                    @endif
                                                    <td>{{ $Driver->name }}</td>
                                                    <td>{{ $Driver->email }}</td>
                                                    <td>{{ $Driver->phone }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-dark" style="width:50px;height:24px;padding:0;">Info</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Blokir --}}
                                <div class="tab-pane" id="blokirSupir-tab">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                              <th scope="col" width="3%">#</th>
                                              <th scope="col" width="11%">Avatar</th>
                                              <th scope="col" width="25%">Nama</th>
                                              <th scope="col" width="25%">E-mail</th>
                                              <th scope="col" width="25%">Phone</th>
                                              <th scope="col" width="11%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($DriversBlocked as $Key =>  $Driver)
                                                <tr>
                                                    <th scope="row">{{ ++$Key }}</th>
                                                    @if(!empty($Driver->avatar))
                                                      <td><img src="{{asset('storage/blog/' . $User->avatar)}}" style="width:50%;"></td>
                                                    @else
                                                      <td>-</td>
                                                    @endif
                                                    <td>{{ $Driver->name }}</td>
                                                    <td>{{ $Driver->email }}</td>
                                                    <td>{{ $Driver->phone }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-dark" style="width:50px;height:24px;padding:0;">Info</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a style="font-weight:bold;font-size:23px;"  href="/supir">More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
