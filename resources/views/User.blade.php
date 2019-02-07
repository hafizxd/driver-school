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
                        <a class="nav-link active" id="user-tab" data-toggle="pill" href="#pegguna-tab" role="tab" aria-controls="pegguna-tab" aria-selected="true" onclick="localStorage.setItem('i', 1);">Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="booking-tab" data-toggle="pill" href="#blokirPengguna-tab" role="tab" aria-controls="bookings-tab" aria-selected="false" onclick="localStorage.setItem('i', 2);">Blokir</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    {{-- Pengguna --}}
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">cari</span>
                        </div>
                        <input type="text" class="form-control" id="nameSearch" placeholder="cari pengguna..." aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="tab-pane show active" id="pegguna-tab" role="tabpanel" aria-labelledby="pegguna-tab">
                        <table class="table table-hover" id="tableOri">
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
                                        <th scope="row">{{ ($Users->currentpage()-1) * $Users->perpage() + $Key + 1 }}</th>
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
                        <table class="table" id="tableSearch" style="display:none">
                            <thead>
                                <tr>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="search-tbody">

                            </tbody>
                        </table>
                        {{ $Users->links() }}
                    </div>

                    {{-- Blokir --}}
                    <div class="tab-pane" id="blokirPengguna-tab">
                        <table class="table table-hover" id="tableOri">
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
                                @foreach($UsersBlocked as $Key => $User)
                                    <tr>
                                        <th scope="row">{{ ++$Key }}</th>
                                        <td>
                                            @if(!empty($User->avatar))
                                            <img class="img-thumbnail" width="50" src="/img/user/{{ $User->avatar }}" alt="">
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
                        {{ $UsersBlocked->links() }}
                    </div>

                </div>
            </div>
        </div>
        <br>
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
                var someUrl = "/user/search/"+document.getElementById("nameSearch").value;
                $.ajax({
                    type:"GET",
                    url: someUrl,
                    success: function(data) {
                        $.each(data, function(index, element) {
                            if(element.avatar != null){
                                imageCheck = '<td><img class="img-thumbnail" width="70" src="/img/user/'+ element.avatar +'" ></td>';
                            }else{
                                imageCheck = '<td><img class="img-thumbnail" width="70" src="'+ element.avatar +'" ></td>';
                            }
                            var html = '<tr>'+imageCheck+'<td>'+ element.name +'</td><td>'+ element.email +'</td><td><a href="/user/'+ element.id +'" class="btn btn-dark">edit</a></td></tr>'
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

@section('javascript')
  <script type="text/javascript">
      var j = localStorage.getItem("i");
      if(j == 2){
          document.getElementById("booking-tab").classList.add('active');
          document.getElementById("blokirPengguna-tab").classList.add('show', 'active');
          document.getElementById("user-tab").classList.remove('active');
          document.getElementById("pegguna-tab").classList.remove('show', 'active');
      }
  </script>
@endsection
