@extends('layouts.app')

@section('title') Driver Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="/driver" class="btn btn-outline-dark" style="margin-bottom:20px;">Kembali</a>
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-outline-danger" href="#" role="button">Block</a>
                    </div>
                    <div class="card-body">


                        {!! Form::open(['url' => '/driver/update', 'method' => 'POST', 'files' => true]) !!}
                        {{ Form::token() }}
                            <input type="hidden" name="id" value="{{ $Driver->id }}">
                            <center>
                                <img class="img-thumbnail" src="/img/driver/ {{ $Driver->avatar }}" alt="">
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
                                <label>Alamat</label>
                                <input name="alamat" type="text" class="form-control" value="{{ $Driver->alamat }}">
                            </div>
                            <div class="form-group">
                                <label>Tipe Mobil</label>
                                <input name="tipe_mobil" type="text" class="form-control" value="{{ $Driver->tipe_mobil }}">
                            </div>
                            <div class="form-group">
                                <label>Max Penumpang</label>
                                <input name="max_penumpang" type="number" class="form-control" value="{{ $Driver->max_penumpang }}">
                            </div>
                            <div class="form-group">
                                <label>Gender Penumpang</label>
                                <select class="form-control" name="gender_penumpang">
                                    <option @if($Driver->gender_penumpang == 'Campur') selected @endif>Campur</option>
                                    <option @if($Driver->gender_penumpang == 'Laki-Laki') selected @endif>Laki-Laki</option>
                                    <option @if($Driver->gender_penumpang == 'Perempuan') selected @endif>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tujuan</label>
                                <input name="tujuan" type="text" class="form-control" value="{{ $Driver->tujuan }}">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input name="alamat" type="text" class="form-control" value="{{ $Driver->alamat }}">
                            </div>

                            <div class="form-group">
                                <label>Foto Mobil</label>

                            <center>
                                <img class="img-thumbnail" src="/img/mobil/ {{ $Driver->image->images }}" alt="">
                            </center>
                                <input type="file" name="image">
                            </div>


                            <div class="text-center">
                                <a href="/driver" class="btn btn-danger">Batal</a>
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
