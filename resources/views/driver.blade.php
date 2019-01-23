@extends('layouts.app')

@section('title') Supir | DriverSchool @endsection

@section('content')
<div class="container">

    {{-- Wrapper Navigation Content --}}
    <div class="tab-content" id="pills-tabContent">

        {{-- Content Supir --}}
        <div class="tab-pane fade show active" id="drivers-tab" role="tabpanel" aria-labelledby="drivers-tab">
            <div class="row justify-content-center">
                <div class="col-md-10">
                  <a href="/home" class="btn btn-dark" style="margin-bottom:20px;">Beranda</a>
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
                                    <a class="nav-link" id="booking-tab" data-toggle="pill" href="#blokirSupir-tab" role="tab" aria-controls="bookings-tab" aria-selected="false">Blokir</a>
                                </li>
                            </ul>
                            <br>

                            <div class="tab-content">
                                {{-- Supir --}}
                                <div class="tab-pane show active" id="supir-tab" role="tabpanel" aria-labelledby="supir-tab">
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
                                            @foreach($Drivers as $Key => $Driver)
                                                <tr>
                                                    <th scope="row">{{ ++$Key }}</th>
                                                    @if(!empty($Driver->avatar))
                                                      <td><img src="{{asset('storage/blog/' . $Driver->avatar)}}" style="max-height:34px;max-width:100%;"></td>
                                                    @else
                                                      <td>-</td>
                                                    @endif
                                                    <td>{{ $Driver->name }}</td>
                                                    <td>{{ $Driver->email }}</td>
                                                    <td>
                                                        <a href="/driver/{{$Driver->id}}" class="btn btn-dark" style="width:50px;height:24px;padding:0;">Info</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Blokir --}}
                                <div class="tab-pane" id="blokirSupir-tab">
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
                                            @foreach($DriversBlocked as $Key => $Driver)
                                                <tr>
                                                    <th scope="row">{{ ++$Key }}</th>
                                                    @if(!empty($Driver->avatar))
                                                      <td><img src="{{asset('storage/blog/' . $Driver->avatar)}}" style="max-height:34px;max-width:100%;"></td>
                                                    @else
                                                      <td>-</td>
                                                    @endif
                                                    <td>{{ $Driver->name }}</td>
                                                    <td>{{ $Driver->email }}</td>
                                                    <td>
                                                        <a href="/user/{{$Driver->id}}" class="btn btn-dark" style="width:50px;height:24px;padding:0;">Info</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
