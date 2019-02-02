@extends('layouts.app')

@section('title') Driver Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="/driver" class="btn btn-outline-dark" style="margin-bottom:20px;">Kembali</a>
                <div class="card">
                    <div class="card-header">
                        @if($Driver->role == 0) <a class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#modalUnblock">Unblock</a> @endif
                        @if($Driver->role == 2) <a class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#modalBlock">Block</a> @endif
                        @if($Driver->role == 4) <h3>Pending Driver</h3> @endif
                    </div>

                    <div class="btn-group" role="group" aria-label="Basic example">
                       <div class="modal fade" id="modalUnblock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                         <div class="modal-dialog modal-dialog-centered" role="document">
                           <div class="modal-content">
                             <div class="modal-header">
                               <h5 class="modal-title" id="exampleModalLongTitle">Unblock Driver</h5>
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                               </button>
                             </div>
                             <div class="modal-body">
                               <h1>Unblock driver <b>{{ $Driver->name }}</b> ?</h1>
                             </div>
                             <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                               <a class="btn btn-primary" href="{{$Driver->id}}/block">Unblock</a>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>

                     <div class="btn-group" role="group" aria-label="Basic example">
                        <div class="modal fade" id="modalBlock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Block Driver</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h1>Block driver <b>{{ $Driver->name }}</b> ?</h1>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-danger" href="{{$Driver->id}}/block">Block</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                    <div class="card-body">
                        @if($Driver->role == 0 | $Driver->role == 2)
                            {!! Form::open(['url' => '/driver/update', 'method' => 'POST', 'files' => true]) !!}
                            {{ Form::token() }}
                                <input type="hidden" name="id" value="{{ $Driver->id }}">
                                <center>
                                    <img class="img-thumbnail" src="/img/driver/{{ $Driver->avatar }}" alt="">
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
                                    <label>Phone</label>
                                    <input name="phone" type="number" class="form-control" value="{{ $Driver->phone }}">
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
                                        <option @if($Driver->gender_penumpang == 0) selected @endif value=0>Campur</option>
                                        <option @if($Driver->gender_penumpang == 1) selected @endif value=1>Laki-Laki</option>
                                        <option @if($Driver->gender_penumpang == 2) selected @endif value=2>Perempuan</option>
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

                                    @if(!empty($Driver->image->images))
                                        <center>
                                            <img class="img-thumbnail" src="/img/mobil/{{ $Driver->image->images }}" alt="gaada">
                                        </center>
                                            <input type="file" name="image">
                                    @else
                                        <br> -
                                    @endif
                                </div>


                                <div class="text-center">
                                    <button type="reset" class="btn btn-danger">Batal</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            {!! Form::close() !!}

                        @elseif($Driver->role == 4)
                                <input type="hidden" name="id" value="{{ $Driver->id }}">
                                <div class="form-group">
                                    <center>
                                        <img class="img-thumbnail" src="/img/driver/{{ $Driver->avatar }}" alt="">
                                    </center>
                                    <br>
                                </div>

                                <div class="form-group">
                                  <label>Nama</label>
                                  <input name="name" type="text" class="form-control" value="{{ $Driver->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input name="email" type="email" class="form-control" value="{{ $Driver->email }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input name="phone" type="number" class="form-control" value="{{ $Driver->phone }}">
                                </div>
                                <div class="form-group">
                                    <label>Tipe Mobil</label>
                                    <input name="tipe_mobil" type="text" class="form-control" value="{{ $Driver->tipe_mobil }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Max Penumpang</label>
                                    <input name="max_penumpang" type="number" class="form-control" value="{{ $Driver->max_penumpang }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Gender Penumpang</label>
                                    <select class="form-control" name="gender_penumpang" disabled>
                                        <option @if($Driver->gender_penumpang == 0) selected @endif value=0>Campur</option>
                                        <option @if($Driver->gender_penumpang == 1) selected @endif value=1>Laki-Laki</option>
                                        <option @if($Driver->gender_penumpang == 2) selected @endif value=2>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tujuan</label>
                                    <input name="tujuan" type="text" class="form-control" value="{{ $Driver->tujuan }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input name="alamat" type="text" class="form-control" value="{{ $Driver->alamat }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Foto Mobil</label>

                                    @if(!empty($Driver->image->images))
                                        <center>
                                            <img class="img-thumbnail" src="/img/mobil/{{ $Driver->image->images }}" alt="img-car">
                                        </center>
                                    @else
                                        <br> -
                                    @endif
                                </div>


                        <div class="text-center">
                            <a href="/driver/{{$Driver->id}}/decline" class="btn btn-danger">Tolak Driver</a>
                            <a href="/driver/{{$Driver->id}}/accept" class="btn btn-warning">Terima Driver</a>
                        </div>
                    @endif

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
