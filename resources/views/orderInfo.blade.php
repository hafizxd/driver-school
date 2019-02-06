@extends('layouts.app')

@section('title') Order Info | DriverSchool @endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
          <a href="/order" class="btn btn-outline-dark" style="margin-bottom:20px;">Back</a>
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-outline-danger " data-toggle="modal" data-target="#modalCancelOrder">Batalkan</a>

                    {{-- Modal Batalkan Pesanan --}}
                    <div class="modal fade" id="modalCancelOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Batalkan Langganan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <h1>Batalkan Langganan <b>{{ $Order->user->name }}</b> dengan Supir <b>{{ $Order->driver->name }}</b> </h1>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <a href="/order/cancel/{{ $Order->id }}" class="btn btn-danger">Batalkan</a>
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
                <div class="card-body">

                  {!! Form::open(['url' => '/order/update', 'method' => 'POST']) !!}
                  {{ Form::token() }}
                    <input type="hidden" name="id" value="{{ $Order->id }}">
                    <div class="form-group">
                      <label>Pelanggan</label>
                      <input name="pelanggan" type="text" class="form-control" value="{{ $Order->user->name }}" readonly>
                    </div>
                    <div class="form-group">
                      <label>Supir</label>
                      <input name="supir" type="text" class="form-control" value="{{ $Order->driver->name }}" readonly>
                    </div>
                    <div class="form-group">
                      <label>Panjang Kontrak</label>
                      <input name="plan" type="text" class="form-control" value="{{ $Order->plan }}" readonly>
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
                      <?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID'); ?>
                      <label>Mulai Tanggal</label>
                      <input name="start_date" type="text" class="form-control" value="{{ strftime("%A, %B %d %Y", strtotime($Order->date)) }}" readonly>
                    </div>

                    <div class="form-group">
                      <?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID'); ?>
                      <label>Berakhir Tanggal</label>
                      <input name="end_date" type="text" class="form-control" value="{{ utf8_encode(strftime("%A, %B, %d %Y", strtotime($Order->end_date))) }}" readonly>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-success">Simpan</button>
                    </div>

                  {!! Form::close() !!}
             </div>
         </div>
     </div>
 </div>
@endsection
