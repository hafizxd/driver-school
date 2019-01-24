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

                        {!! Form::open(['url' => '/driver/update', 'method' => 'POST', 'files' => true]) !!}
                        {{ Form::token() }}
                            <input type="hidden" name="id" value="{{ $Driver->id }}">
                            <center>
                                <img class="img-thumbnail" src="{{ $Driver->avatar }}" alt="">
                            </center>
                            <br>
                            <div class="form-group">
                                <input name="avatar" type="file" class="form-control-file" accept="image/*" id="exampleFormControlFile1">
                            </div>

                            <div class="form-group">
                              <label>Nama</label>
                              <input name="name" type="text" class="form-control" value="{{ $Driver->name }}">
                            </div>
                            <div class="form-group">
                                <label>E-mail</label>
                                <input name="email" type="email" class="form-control" value="{{ $Driver->email }}">
                            </div>
                            <div class="form-group">
                                <label>Wilayah</label>
                                <input name="wilayah" type="text" class="form-control" value="{{ $Driver->alamat }}">
                            </div>
                            <div class="form-group">
                                <label>Tipe Mobil</label>
                                <input name="tipeMobil" type="text" class="form-control" value="{{ $Driver->tipe_mobil }}">
                            </div>
                            <div class="form-group">
                                <label>Max Penumpang</label>
                                <input name="maxPenumpang" type="number" class="form-control" value="{{ $Driver->max_penumpang }}">
                            </div>
                            <div class="form-group">
                                <label>Gender Penumpang</label>
                                <select class="form-control" id="gender_penumpang">
                                    <option @if($Driver->gender_penumpang == 'Campur') selected @endif>Campur</option>
                                    <option @if($Driver->gender_penumpang == 'Laki-Laki') selected @endif>Laki-laki</option>
                                    <option @if($Driver->gender_penumpang == 'Perempuan') selected @endif>Perempuan</option>
                                </select>
                            </div>

                            <h3>foto mobil</h3>

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

                            <div class="text-center">
                                <a href="../" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        {!! Form::close() !!}

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
