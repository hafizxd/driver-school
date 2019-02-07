@extends('layouts.app')

@section('title') User Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <a href="/user" class="btn btn-outline-dark" style="margin-bottom:20px;">Back</a>
          @if(session()->has('block'))
            <div class="alert alert-success">
              <button class="close" data-dismiss="alert" aria-hidden="true">     &#10004;</button>
              <strong>Notification </strong> {{ session()->get('block') }}
            </div>
          @elseif(session()->has('updateSuccess'))
            <div class="alert alert-success">
              <button class="close" data-dismiss="alert" aria-hidden="true">     &#10004;</button>
              <strong>Notification </strong> {{ session()->get('updateSuccess') }}
            </div>
          @endif
            <div class="card">
                <div class="card-header">
                  @if($User->role == 0) <a class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#modalUnblock">Unblock</a> @endif
                  @if($User->role == 1) <a class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#modalBlock">Block</a> @endif
                </div>

                 <div class="btn-group" role="group" aria-label="Basic example">
                    <div class="modal fade" id="modalUnblock" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Unblock User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <h1>Unblock user <b>{{ $User->name }}</b> ?</h1>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="{{$User->id}}/block">Unblock</a>
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
                             <h5 class="modal-title" id="exampleModalLongTitle">Block User</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                             </button>
                           </div>
                           <div class="modal-body">
                             <h1>Block user <b>{{ $User->name }}</b> ?</h1>
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                             <a class="btn btn-danger" href="{{$User->id}}/block">Block</a>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>

                <div class="card-body">
                  {!! Form::open(['url' => '/user/update', 'method' => 'POST', 'files' => true]) !!}
                  {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $User->id }}">
                    <center>
                        <img class="img-thumbnail" src="/img/user/{{ $User->avatar }}" alt="">
                    </center>
                    <br>
                    <div class="form-group">
                      <input name="avatar" type="file" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                      <label>Nama</label>
                      <input name="name" type="text" class="form-control" value="{{ $User->name }}">
                    </div>
                    <div class="form-group">
                      <label>E-mail</label>
                      <input name="email" type="email" class="form-control" value="{{ $User->email }}">
                    </div>
                    <div class="form-group">
                      <label>Alamat</label>
                      <input name="address" type="text" class="form-control" value="{{ $User->address }}">
                    </div>
                    <div class="form-group">
                      <label>Phone</label>
                      <input name="phone" type="text" class="form-control" value="{{ $User->phone }}">
                    </div>

                    @foreach($User->childs as $Key => $Child)
                        <div class="form-group">
                          <label>Nama Anak {{++$Key}}</label>
                          <input name="child[{{$Key}}]" type="text" class="form-control" value="{{ $Child->name }}">
                        </div>
                    @endforeach

                    <div class="text-center">
                        <button type="reset" class="btn btn-danger">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                  {!! Form::close() !!}


             </div>
         </div>
     </div>
 </div>
@endsection
