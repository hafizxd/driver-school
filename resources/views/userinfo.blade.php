@extends('layouts.app')

@section('title') User Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <a href="/user" class="btn btn-outline-dark" style="margin-bottom:20px;">Back</a>
            <div class="card">
                <div class="card-header">
                  <a class="btn btn-outline-danger" href="#" role="button">Block</a>
                </div>
                <div class="card-body">

                  {!! Form::open(['url' => '/user/update', 'method' => 'POST', 'files' => true]) !!}
                  {{ Form::token() }}
                      <input type="hidden" name="id" value="{{ $Users->id }}">
                      <div class="form-group">
                        <center>
                            @if(!empty($Users->avatar))
                              <img src="{{asset('storage/blog/' . $Users->avatar)}}" alt="foto-profil" class="img-thumbnail">
                            @endif
                        </center>

                      <input name="avatar" type="file" class="from-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                      <label>Nama</label>
                      <input name="name" type="text" class="form-control" value="{{ $Users->name }}">
                    </div>
                    <div class="form-group">
                      <label>E-mail</label>
                      <input name="email" type="email" class="form-control" value="{{ $Users->email }}">
                    </div>
                    <div class="form-group">
                      <label>Alamat</label>
                      <input name="alamat" type="text" class="form-control" value="{{ $Users->alamat }}">
                    </div>
                    <div class="form-group">
                      <label>Phone</label>
                      <input name="phone" type="number" class="form-control" value="{{ $Users->phone }}">
                    </div>
                    <div class="form-group">
                      <label>Bergabung Pada</label>
                      <input name="date" type="text" class="form-control" value="{{ $Users->created_at->format('l, j F Y h:i A') }}" readonly>
                    </div>
                    <div class="text-center">
                        <a href="../" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                    <div class="form-group">
                      <hr width="90%">
                    </div>
                  {!! Form::close() !!}

                  <h3 style="text-align:center;margin-top:40px;">Anak</h3>
                  <table class="table table-hover">
                      <thead>
                          <tr>
                              <th scope="col" width="20%">#</th>
                              <th scope="col" width="50%">Nama</th>
                              <th scope="col" width="30%">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($Users->childs as $Key => $Child)
                              <tr>
                                  <th scope="row">{{ ++$Key }}</th>
                                  <td>{{ $Child->nama }}</td>
                                  <td>
                                      <a href="/user/{{$Users->id}}/child/{{$Child->id}}" class="btn btn-dark" style="width: 60px;">Info</a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
             </div>
         </div>
     </div>
 </div>
@endsection
