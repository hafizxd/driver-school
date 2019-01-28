@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <a class="btn btn-outline-dark" href="/home">Beranda</a>
            <br>
            <br>
            <div class="card">
                <div class="card-header">
                    <h1> Order </h1>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills" style="margin-bottom: 30px;">
                      <li class="nav-item">
                          <a class="nav-link active" id="user-tab" data-toggle="pill" href="#berlaku-tab" role="tab" aria-controls="berlaku-tab" aria-selected="true">Berlaku</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="booking-tab" data-toggle="pill" href="#belumBerlaku-tab" role="tab" aria-controls="belumBerlaku-tab" aria-selected="false">Belum Berlaku</a>
                      </li>
                    </ul>

                    <div class="tab-content">
                        {{-- Berlaku --}}
                        <div class="tab-pane show active" id="berlaku-tab" role="tabpanel" aria-labelledby="berlaku-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="10%">#</th>
                                        <th scope="col" width="30%">Pelanggan</th>
                                        <th scope="col" width="30%">Supir</th>
                                        <th scope="col" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($orders))
                                        @foreach($orders as $Key => $order)
                                            <tr>
                                                <th scope="row">{{ ++$Key }}</th>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->driver->name }}</td>
                                                <td>
                                                    <a href="order/{{ $order->id }}" class="btn btn-dark" style="width: 100px;">Info</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        {{-- Belum Berlaku --}}
                        <div class="tab-pane" id="belumBerlaku-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" width="10%">#</th>
                                        <th scope="col" width="30%">Pelanggan</th>
                                        <th scope="col" width="30%">Supir</th>
                                        <th scope="col" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($ordersBelum))
                                        @foreach($ordersBelum as $Key => $order)
                                            <tr>
                                                <th scope="row">{{ ++$Key }}</th>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->driver->name }}</td>
                                                <td>
                                                    <a href="order/{{ $order->id }}" class="btn btn-dark" style="width: 100px;">Info</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
