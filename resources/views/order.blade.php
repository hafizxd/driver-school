@extends('layouts.app')

@section('title') Langganan | DriverSchool @endsection

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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">cari</span>
                            </div>
                            <input type="text" class="form-control" id="nameSearch" placeholder="cari pengguna..." aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="tab-pane show active" id="berlaku-tab" role="tabpanel" aria-labelledby="berlaku-tab">
                            <table class="table table-hover" id="tableOri">
                                <thead>
                                    <tr>
                                        <th scope="col" width="10%">#</th>
                                        <th scope="col" width="25%">Pelanggan</th>
                                        <th scope="col" width="25%">Supir</th>
                                        <th scope="col" width="25%">Tujuan</th>
                                        <th scope="col" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $Key => $order)
                                        <tr>
                                            <th scope="row">{{ ++$Key }}</th>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->driver->name }}</td>
                                            <td>{{ $order->destination }}</td>
                                            <td>
                                                <a href="order/{{ $order->id }}" class="btn btn-dark" style="width: 100px;">Info</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table" id="tableSearch" style="display:none">
                                <thead>
                                    <tr>
                                        <th scope="col" width="25%">Pelanggan</th>
                                        <th scope="col" width="25%">Supir</th>
                                        <th scope="col" width="35%">Tujuan</th>
                                        <th scope="col" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="search-tbody">

                                </tbody>
                            </table>
                        </div>

                        {{-- Belum Berlaku --}}
                        <div class="tab-pane" id="belumBerlaku-tab">
                            <table class="table table-hover" id="tableOri">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

document.getElementById("nameSearch").addEventListener("keypress", searchUser);
function searchUser(e){
    var key = e.which || e.keycode;
    if(key === 13){
        var tableSearch = document.getElementById("tableSearch");
        var tableOri = document.getElementById("tableOri");
        $( "#search-tbody" ).empty();
        if(document.getElementById("nameSearch").value.length == 0){
            tableOri.style.display = "";
            tableSearch.style.display = "none";
            $('.pagination').css('display','');
        }else{
            tableOri.style.display = "none";
            tableSearch.style.display = "";
            $('.pagination').css('display','none');
            var someUrl = "/order/search/"+document.getElementById("nameSearch").value;
            $.ajax({
                type:"GET",
                url: someUrl,
                success: function(data) {
                    $.each(data, function(index, element) {
                        var html = '<tr>'+'<td>'+ element.user_name +'</td><td>'+ element.driver_name+ '<td>' + element.destination + '</td><td><a href="/order/'+ element.order_id +'" class="btn btn-dark">edit</a></td></tr>'
                        $('#search-tbody').append(html);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "json"
            });
        }
    }
}
});
</script>
@endsection
