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
                                        <td>{{ $order->users->name }}</td>
                                        <td>{{ $order->drivers->name }}</td>
                                        <td>
                                            <a href="#" class="btn btn-dark" style="width: 100px;">Info</a>
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
@endsection