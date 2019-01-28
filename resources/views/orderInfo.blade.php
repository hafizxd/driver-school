@extends('layouts.app')

@section('title') Order Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <a href="/order" class="btn btn-outline-dark" style="margin-bottom:20px;">Back</a>
            <div class="card">
                <div class="card-header">
                    <h3>Info Langganan</h3>
                </div>
                <div class="card-body">

                  {!! Form::open(['url' => '/order/update', 'method' => 'POST']) !!}
                  {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $Order->id }}">
                    <div class="form-group">
                      <label>Pelanggan</label>
                      <input name="pelanggan" type="text" class="form-control" value="{{ $Order->user->name }}">
                    </div>
                    <div class="form-group">
                      <label>Supir</label>
                      <input name="supir" type="text" class="form-control" value="{{ $Order->driver->name }}">
                    </div>
                    <div class="form-group">
                      <label>Keterangan</label>
                      <input name="plan" type="text" class="form-control" value="{{ $Order->plan }}">
                    </div>

                    @if(!empty($Order->childs))
                        @foreach($Order->childs as $Key => $Child)
                            <div class="form-group">
                              <label>Penumpang {{++$Key}}</label>
                              <input name="childs[{{$Key}}]" type="text" class="form-control" value="{{ $Child->name }}">
                            </div>
                        @endforeach
                    @endif

                    <div class="form-group">
                      <label>Mulai Tanggal</label>
                      <input name="start_date" type="date" class="form-control" value="{{ $Order->start_date }}">
                    </div>

                    <div class="form-group">
                      <label>Berakhir Tanggal</label>
                      <input name="end_date" type="date" class="form-control" value="{{ $Order->end_date }}">
                    </div>

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
