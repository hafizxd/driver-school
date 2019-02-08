@extends('layouts.app')

@section('title') Supir | DriverSchool @endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <a href="/home" class="btn btn-outline-dark" style="margin-bottom:20px;">Beranda</a>
      <div class="card">
        <div class="card-header">
          <h1> Supir </h1>
        </div>
        <div class="card-body">
          <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" id="supirNav-tab" data-toggle="pill" href="#supir-tab" role="tab" aria-controls="supir-tab" aria-selected="true" @if(getRole() != 3)) style="display: none;" @endif onclick="localStorage.setItem('supir', 1);">Supir</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="blokirSupirNav-tab" data-toggle="pill" href="#blokirSupir-tab" role="tab" aria-controls="bookings-tab" aria-selected="false" @if(getRole() != 3)) style="display: none;" @endif onclick="localStorage.setItem('supir', 2);">Blokir</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pendingSupirNav-tab" data-toggle="pill" href="#pendingSupir-tab" role="tab" aria-controls="pending-tab" aria-selected="false" @if(getRole() != 3)) style="display: none;" @endif onclick="localStorage.setItem('supir', 3);">Pending</a>
            </li>
          </ul>
          <br>

            <div class="tab-content">
                {{-- Supir --}}
                <div class="tab-pane show active" id="supir-tab" role="tabpanel" aria-labelledby="supir-tab">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="15%">Avatar</th>
                                <th scope="col" width="32%">Nama</th>
                                <th scope="col" width="32%">E-mail</th>
                                <th scope="col" width="15%" @if(getRole() != 3)) style="display: none;" @endif >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Drivers as $Key => $Driver)
                                <tr>
                                    <th scope="row">{{ ++$Key }}</th>
                                    <td>
                                        @if(!empty($Driver->avatar))
                                            <img class="img-thumbnail" width="50" src="/img/driver/{{ $Driver->avatar }}" alt="">
                                        @else
                                            <img class="img-thumbnail" width="50" src="{{ $Driver->avatar }}" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $Driver->name }}</td>
                                    <td>{{ $Driver->email }}</td>
                                    <td @if(getRole() != 3)) style="display: none;" @endif >
                                        <a href="/driver/{{$Driver->id}}" class="btn btn-dark" style="width:100px;">Info</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $Drivers->links() }}
                </div>

                {{-- Blokir --}}
                <div class="tab-pane" id="blokirSupir-tab">
                    <table class="table table-hover">
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
                                    <td>
                                        @if(!empty($Driver->avatar))
                                            <img class="img-thumbnail" width="50" src="/img/driver/{{ $Driver->avatar }}" alt="">
                                        @else
                                            <img class="img-thumbnail" width="50" src="{{ $Driver->avatar }}" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $Driver->name }}</td>
                                    <td>{{ $Driver->email }}</td>
                                    <td>
                                        <a href="/driver/{{$Driver->id}}" class="btn btn-dark" style="width:100px;">Info</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $DriversBlocked->links() }}
                </div>

                {{-- Pending --}}
                <div class="tab-pane" id="pendingSupir-tab">
                    <table class="table table-hover">
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
                            @foreach($DriversPending as $Key => $Driver)
                                <tr>
                                    <th scope="row">{{ ++$Key }}</th>
                                    <td>
                                        @if(!empty($Driver->avatar))
                                            <img class="img-thumbnail" width="50" src="/img/driver/{{ $Driver->avatar }}" alt="">
                                        @else
                                            <img class="img-thumbnail" width="50" src="/img/driver/{{ $Driver->avatar }}" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $Driver->name }}</td>
                                    <td>{{ $Driver->email }}</td>
                                    <td>
                                        <a href="/driver/{{$Driver->id}}" class="btn btn-dark" style="width:100px;">Info</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $DriversPending->links() }}
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var v = localStorage.getItem("supir");
    if (v == 2){
        document.getElementById("blokirSupirNav-tab").classList.add('active');
        document.getElementById("blokirSupir-tab").classList.add('show', 'active');
        document.getElementById("supirNav-tab").classList.remove('active');
        document.getElementById("supir-tab").classList.remove('show', 'active');
        document.getElementById("pendingSupirNav-tab").classList.remove('active');
        document.getElementById("pendingSupir-tab").classList.remove('show', 'active');
    }

    if (v == 3){
        document.getElementById("pendingSupirNav-tab").classList.add('active');
        document.getElementById("pendingSupir-tab").classList.add('show', 'active');
        document.getElementById("blokirSupirNav-tab").classList.remove('active');
        document.getElementById("blokirSupir-tab").classList.remove('show', 'active');
        document.getElementById("supirNav-tab").classList.remove('active');
        document.getElementById("supir-tab").classList.remove('show', 'active');
    }
</script>
@endsection
