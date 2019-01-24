@extends('layouts.app')

@section('title') Driver Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="/driver" class="btn btn-outline-dark" style="margin-bottom:20px;">Back</a>
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-outline-danger" href="#" role="button">Block</a>
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
                                <label>Phone</label>
                                <input name="phone" type="number" class="form-control" value="{{ $Drivers->phone }}">
                            </div>
                            <div class="form-group">
                                <label>Tipe Mobil</label>
                                <input name="tipe_mobil" type="text" class="form-control" value="{{ $Drivers->tipe_mobil }}">
                            </div>
                            <div class="form-group">
                                <label>Max Penumpang</label>
                                <input name="max_penumpang" type="number" class="form-control" value="{{ $Drivers->max_penumpang }}">
                            </div>
                            <div class="form-group">
                                <label>Gender Penumpang</label>
                                <select class="form-control" name="gender_penumpang">
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
                            <div class="form-group">
                                <label>Tujuan</label>
                                <input name="tujuan" type="text" class="form-control" value="{{ $Drivers->tujuan }}">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input name="alamat" type="text" class="form-control" value="{{ $Drivers->alamat }}">
                            </div>
                            <input class="btn btn-outline-primary" type="submit" name="submit" value="Simpan" style="margin-top:20px;">
                                {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <hr width="90%">
                            </div>
                        </form>

                        <h3 style="margin-top:40px;">Foto Mobil</h3>
                        <form action="/image/create/{{$Drivers->id}}" method="post" enctype="multipart/form-data">
                            <label for="replace-image" class="btn btn-outline-dark">Tambah Foto</label>
                            <input type="file" name="image" style="display:none;" id="replace-image" onchange="this.form.submit()">
                                  {{ csrf_field() }}
                        </form>

                        @foreach($Drivers->images as $Image)
                            <div class="row" style="margin-top: 30px;">
                                <div class="col-md-7">
                                    <img src="{{asset('storage/blog/' . $Image->images)}}" alt="gaada" style="width:100%;display:block;">
                                </div>
                                <div class="col-md-5">
                                    <a href="/image/delete/{{$Image->id}}" class="btn btn-outline-danger" style="vertical-align: text-bottom;">Hapus</a>
                                    <form action="/image/edit/{{$Image->id}}" method="post" enctype="multipart/form-data">
                                        <label for="replace-image" class="btn btn-outline-primary">Ganti Foto</label>
                                        <input type="file" name="image" style="display:none;" id="replace-image" onchange="this.form.submit()">
                                              {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="PUT">
                                    </form>
                                </div>
                            </div>
                        @endforeach

                  </div>
              </div>
          </div>
     </div>
 </div>
@endsection

@section('js')
    <script type="text/javascript">
    </script>
@endsection
