@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                  <h1>User</h1>
                </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <div class="container" style="margin-top:15px; margin-bottom:15px;">
                  <div class="row">
                    <div class="col-md-4 text-center">
                      <div class="card card-body" style="padding:0;">
                        <img class="img-thumbnail" src="p.jpg" alt="" style="margin-bottom:10px;">
                        <a style="text-decoration='none';" href="#">apalah 1</a>
                      </div>
                    </div>
                    <div class="col-md-4 text-center">
                      <div class="card card-body">
                        <img class="img-responsive" src="" alt="">
                        <a style="text-decoration='none';" href="#">apalah 2</a>
                      </div>
                    </div>
                    <div class="col-md-4 text-center">
                      <div class="card card-body">
                        <img class="img-responsive" src="" alt="">
                        <a style="text-decoration='none';" href="#">apalah 3</a>
                      </div>
                    </div>
                  </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
