@extends('layouts.app')

@section('title') Driver Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="/home" class="btn btn-dark" style="margin-bottom:20px;">Beranda</a>
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-danger" href="#" role="button">Block</a>
                    </div>
                    <div class="card-body">
                        <form action="/driver/{{$Drivers->id}}/edit" method="post" enctype="multipart/form-data">
                            @if(!empty($Drivers->avatar))
                                <img src="{{asset('storage/blog/' . $Drivers->avatar)}}" alt="foto-profil" style="width:50%;margin:auto;margin-bottom:10px;display:block;">
                            @endif
                          <div class="form-group">
                              <input name="avatar" type="file" class="from-control-file">
                          </div>
                          <div class="form-group">
                              <label>Nama</label>
                              <input name="name" type="text" class="form-control" value="{{ $Drivers->name }}">
                          </div>
                          <div class="form-group">
                              <label>E-mail</label>
                              <input name="email" type="email" class="form-control" value="{{ $Drivers->email }}">
                          </div>
                          <div class="form-group">
                              <label>Wilayah</label>
                              <input name="wilayah" type="text" class="form-control" value="{{ $Drivers->alamat }}">
                          </div>
                          <div class="form-group">
                              <label>Tipe Mobil</label>
                              <input name="tipeMobil" type="text" class="form-control" value="{{ $Drivers->tipe_mobil }}">
                          </div>
                          <div class="form-group">
                              <label>Max Penumpang</label>
                              <input name="maxPenumpang" type="number" class="form-control" value="{{ $Drivers->max_penumpang }}">
                          </div>
                          <div class="form-group">
                              <label>Gender Penumpang</label>
                              <select class="form-control">
                                  @if($Drivers->gender_penumpang == 'Campur')
                                      <option>Campur</option>
                                      <option>Laki-laki</option>
                                      <option>Perempuan</option>
                                  @elseif($Drivers->gender_penumpang == 'Laki-laki')
                                      <option>Laki-laki</option>
                                      <option>Perempuan</option>
                                      <option>Campur</option>
                                  @elseif($Drivers->gender_penumpang == 'Perempuan')
                                      <option>Perempuan</option>
                                      <option>Laki-laki</option>
                                      <option>Campur</option>
                                  @else
                                      <option>-</option>
                                  @endif
                              </select>
                          </div>
                          <input class="btn btn-default" type="submit" name="submit" value="Edit" style="margin-top:20px;">
                              {{ csrf_field() }}
                          <input type="hidden" name="_method" value="PUT">
                          <div class="form-group">
                              <hr width="90%">
                          </div>
                        </form>
                        <h3 style="margin-top:40px;">Foto Mobil</h3>
                  </div>
              </div>
          </div>
     </div>
 </div>
@endsection
